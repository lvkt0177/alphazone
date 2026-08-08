<?php

namespace App\Http\Controllers\Admin;

use App\Enum\TrangThaiCoSo;
use App\Enum\TrangThaiDiemDanh;
use App\Enum\TrangThaiHocVien;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DiemDanh\DiemDanhBuRequest;
use App\Http\Requests\Admin\DiemDanh\DiemDanhRequest;
use App\Models\CoSo;
use App\Models\DiemDanh;
use App\Models\HocVien;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DiemDanhController extends Controller
{
    public function index(Request $request)
    {
        $coSos = CoSo::where('trang_thai', TrangThaiCoSo::ACTIVE)->orderBy('ten')->get();

        $selectedCoSoId = $request->integer('co_so_id') ?: optional($coSos->first())->id;
        $selectedDate = $request->input('ngay') ?: now()->toDateString();

        $hocViens = collect();
        $existing = collect();
        $soDiHoc = 0;
        $soVang = 0;
        $nguoiCapNhatCuoi = null;
        $daDiemDanh = false;

        if ($selectedCoSoId) {
            $hocViens = HocVien::whereHas('coSos', fn ($q) => $q->where('co_sos.id', $selectedCoSoId))
                ->whereIn('trang_thai', [TrangThaiHocVien::KHACH_HANG, TrangThaiHocVien::QUAY_LAI])
                ->orderBy('ho_ten')
                ->get();

            $existing = DiemDanh::with('updatedBy')
                ->where('co_so_id', $selectedCoSoId)
                ->where('ngay', $selectedDate)
                ->get()
                ->keyBy('hoc_vien_id');

            $soDiHoc = $existing->where('trang_thai', TrangThaiDiemDanh::DI_HOC)->count();
            $soVang = $existing->where('trang_thai', TrangThaiDiemDanh::VANG)->count();
            $daDiemDanh = $existing->isNotEmpty();

            $banGhiCapNhatCuoi = $existing->sortByDesc('updated_at')->first();
            $nguoiCapNhatCuoi = $banGhiCapNhatCuoi?->updatedBy;

            $hocBuIds = $existing->filter(fn ($dd) => $dd->hoc_bu)->pluck('hoc_vien_id');
            $hocViensBu = $hocBuIds->isNotEmpty()
                ? HocVien::whereIn('id', $hocBuIds)->orderBy('ho_ten')->get()
                : collect();

            $hocViensChoHocBu = HocVien::whereDoesntHave('coSos', fn ($q) => $q->where('co_sos.id', $selectedCoSoId))
                ->whereNotIn('id', $hocBuIds)
                ->whereIn('trang_thai', [TrangThaiHocVien::KHACH_HANG, TrangThaiHocVien::QUAY_LAI])
                ->orderBy('ho_ten')
                ->get();
        } else {
            $hocViensBu = collect();
            $hocViensChoHocBu = collect();
        }

        return view('attendance.index', compact(
            'coSos', 'selectedCoSoId', 'selectedDate', 'hocViens', 'existing', 'hocViensBu', 'hocViensChoHocBu',
            'soDiHoc', 'soVang', 'nguoiCapNhatCuoi', 'daDiemDanh'
        ));
    }

    public function store(DiemDanhRequest $request)
    {
        $coSo = CoSo::findOrFail($request->co_so_id);

        $daDiemDanhTruoc = DiemDanh::where('co_so_id', $request->co_so_id)
            ->where('ngay', $request->ngay)
            ->exists();

        if ($daDiemDanhTruoc && ! hasQuyen('diemdanh', 'sua')) {
            return redirect()
                ->route('diemdanh.index', ['co_so_id' => $request->co_so_id, 'ngay' => $request->ngay])
                ->with('error', 'Đã điểm danh cho ngày này rồi. Cần có quyền Sửa điểm danh để chỉnh lại.');
        }

        foreach ($request->diem_danh as $row) {
            DiemDanh::updateOrCreate(
                [
                    'hoc_vien_id' => $row['hoc_vien_id'],
                    'co_so_id' => $request->co_so_id,
                    'ngay' => $request->ngay,
                ],
                [
                    'giao_vien_id' => $coSo->giao_vien_id,
                    'trang_thai' => $row['trang_thai'],
                    'ghi_chu' => $row['ghi_chu'] ?? null,
                    'hoc_bu' => $row['hoc_bu'] ?? false,
                    'updated_by_user_id' => auth()->id(),
                ]
            );
        }

        return redirect()
            ->route('diemdanh.index', ['co_so_id' => $request->co_so_id, 'ngay' => $request->ngay])
            ->with('success', 'Lưu điểm danh thành công');
    }

    public function themHocBu(DiemDanhBuRequest $request)
    {
        $coSo = CoSo::findOrFail($request->co_so_id);

        DiemDanh::updateOrCreate(
            [
                'hoc_vien_id' => $request->hoc_vien_id,
                'co_so_id' => $request->co_so_id,
                'ngay' => $request->ngay,
            ],
            [
                'giao_vien_id' => $coSo->giao_vien_id,
                'trang_thai' => TrangThaiDiemDanh::DI_HOC,
                'hoc_bu' => true,
                'updated_by_user_id' => auth()->id(),
            ]
        );

        return redirect()
            ->route('diemdanh.index', ['co_so_id' => $request->co_so_id, 'ngay' => $request->ngay])
            ->with('success', 'Đã thêm học viên học bù vào danh sách điểm danh');
    }

    public function xoaHocBu(DiemDanh $diemdanh)
    {
        if (! $diemdanh->hoc_bu) {
            return redirect()->route('diemdanh.index')->with('error',
                'Không thể xoá: bản ghi này không phải học bù.'
            );
        }

        $coSoId = $diemdanh->co_so_id;
        $ngay = $diemdanh->ngay->toDateString();

        $diemdanh->delete();

        return redirect()
            ->route('diemdanh.index', ['co_so_id' => $coSoId, 'ngay' => $ngay])
            ->with('success', 'Đã xoá học viên học bù khỏi danh sách điểm danh');
    }

    public function xoaTatCa(Request $request)
    {
        $request->validate([
            'co_so_id' => 'required|exists:co_sos,id',
            'ngay' => 'required|date',
        ]);

        $soLuong = DiemDanh::where('co_so_id', $request->co_so_id)
            ->where('ngay', $request->ngay)
            ->count();

        if ($soLuong === 0) {
            return redirect()
                ->route('diemdanh.index', ['co_so_id' => $request->co_so_id, 'ngay' => $request->ngay])
                ->with('error', 'Ngày này chưa có bản ghi điểm danh nào để xoá.');
        }

        DiemDanh::where('co_so_id', $request->co_so_id)
            ->where('ngay', $request->ngay)
            ->delete();

        return redirect()
            ->route('diemdanh.index', ['co_so_id' => $request->co_so_id, 'ngay' => $request->ngay])
            ->with('success', 'Đã xoá toàn bộ bảng điểm danh ngày '.Carbon::parse($request->ngay)->format('d/m/Y'));
    }
}
