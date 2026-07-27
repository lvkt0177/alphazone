<?php

namespace App\Http\Controllers\Admin;

use App\Enum\TrangThaiCoSo;
use App\Enum\TrangThaiLoaiDangKyTraiNghiem;
use App\Exports\HocVienExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HocVien\HocVienRequest;
use App\Models\CoSo;
use App\Models\HocVien;
use App\Models\HocVienTraiNghiem;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class HocVienController extends Controller
{
    public function index(Request $request)
    {
        $query = HocVien::with('coSos');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(fn ($sub) => $sub->where('ma_so', 'like', "%{$q}%")
                ->orWhereUnaccentedLike('ho_ten', $q)
                ->orWhere('sdt', 'like', "%{$q}%"));
        }

        if ($request->filled('co_so_id')) {
            $query->whereHas('coSos', fn ($sub) => $sub->where('co_sos.id', $request->co_so_id));
        }

        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        $hocViens = $query->orderBy('id', 'desc')->paginate(20)->withQueryString();
        $coSos = CoSo::orderBy('ten')->get();

        return view('students.index', compact('hocViens', 'coSos'));
    }

    public function export(Request $request)
    {
        $filters = $request->only(['q', 'co_so_id', 'trang_thai']);

        return Excel::download(new HocVienExport($filters), 'danh-sach-hoc-vien.xlsx');
    }

    public function show(HocVien $hocvien)
    {
        $hocvien->load('coSos');

        $diemDanhs = $hocvien->diemDanhs()
            ->with(['coSo', 'giaoVien'])
            ->orderByDesc('ngay')
            ->paginate(10, ['*'], 'trang_diem_danh');

        $hocPhis = $hocvien->hocPhis()
            ->with('nguoiGioiThieu')
            ->orderByDesc('thang')
            ->paginate(10, ['*'], 'trang_hoc_phi');

        return view('students.detail', compact('hocvien', 'diemDanhs', 'hocPhis'));
    }

    public function create()
    {
        $coSos = CoSo::where('trang_thai', TrangThaiCoSo::ACTIVE)->orderBy('ten')->get();

        $traiNghiems = HocVienTraiNghiem::with('coSos')
            ->where('trang_thai', '!=', TrangThaiLoaiDangKyTraiNghiem::DA_DANG_KY)
            ->orderBy('ho_ten')->get();

        return view('students.create', compact('coSos', 'traiNghiems'));
    }

    public function goiYMaSo(Request $request)
    {
        $prefix = trim((string) $request->input('prefix'));

        if ($prefix === '') {
            return response()->json(['suggestion' => null]);
        }

        $maxSo = HocVien::where('ma_so', 'like', $prefix.'%')
            ->pluck('ma_so')
            ->map(function ($maSo) use ($prefix) {
                $rest = substr($maSo, strlen($prefix));
                $rest = preg_replace('/^\D+/', '', $rest);

                return is_numeric($rest) ? (int) $rest : null;
            })
            ->filter(fn ($n) => $n !== null)
            ->max();

        if ($maxSo === null) {
            return response()->json(['suggestion' => null]);
        }

        return response()->json([
            'suggestion' => $prefix.($maxSo + 1),
            'so_lon_nhat' => $prefix.$maxSo,
        ]);
    }

    public function store(HocVienRequest $request)
    {
        $data = $request->validated();
        $coSoIds = $data['co_so_ids'];
        $traiNghiemId = $data['tu_trai_nghiem_id'] ?? null;
        unset($data['co_so_ids'], $data['tu_trai_nghiem_id']);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('hoc-vien-avatars', 'public');
        }
        $data['tu_hoc_vien_trai_nghiem_id'] = $traiNghiemId;

        $hocVien = HocVien::create($data);
        $hocVien->coSos()->sync($coSoIds);

        if ($traiNghiemId) {
            HocVienTraiNghiem::whereKey($traiNghiemId)
                ->update(['trang_thai' => TrangThaiLoaiDangKyTraiNghiem::DA_DANG_KY]);
        }

        return redirect()->route('hocvien.index')->with('success', 'Thêm học viên thành công');
    }

    public function update(HocVienRequest $request, HocVien $hocvien)
    {
        $data = $request->validated();
        $coSoIds = $data['co_so_ids'];
        unset($data['co_so_ids'], $data['tu_trai_nghiem_id']);

        if ($request->hasFile('avatar')) {
            if ($hocvien->avatar) {
                Storage::disk('public')->delete($hocvien->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('hoc-vien-avatars', 'public');
        }

        $hocvien->update($data);
        $hocvien->coSos()->sync($coSoIds);

        return redirect()->route('hocvien.index')->with('success', "Cập nhật học viên \"{$hocvien->ho_ten}\" thành công");
    }

    public function destroy(HocVien $hocvien)
    {
        try {
            $hocvien->delete();
        } catch (QueryException $e) {
            return redirect()->route('hocvien.index')->with('error',
                'Không thể xoá: học viên này đã có dữ liệu Điểm danh hoặc Học phí liên quan. '
                .'Hãy chuyển học viên sang trạng thái "Tạm nghỉ" thay vì xoá.'
            );
        }

        if ($hocvien->avatar) {
            Storage::disk('public')->delete($hocvien->avatar);
        }

        return redirect()->route('hocvien.index')->with('success', 'Xoá học viên thành công');
    }
}