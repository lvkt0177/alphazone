<?php

namespace App\Http\Controllers\Admin;

use App\Enum\TrangThaiCoSo;
use App\Enum\TrangThaiLoaiDangKyTraiNghiem;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HocVienTraiNghiem\HocVienTraiNghiemRequest;
use App\Models\CoSo;
use App\Models\HocVienTraiNghiem;
use Illuminate\Http\Request;

class HocVienTraiNghiemController extends Controller
{
    public function index(Request $request)
    {
        $query = HocVienTraiNghiem::with('coSos');

        if ($request->filled('ho_ten')) {
            $kw = $request->ho_ten;
            $query->where(fn ($sub) => $sub->whereUnaccentedLike('ho_ten', $kw)
                ->orWhere('sdt', 'like', "%{$kw}%"));
        }

        if ($request->filled('co_so_id')) {
            $coSoId = $request->co_so_id;
            $query->whereHas('coSos', fn ($sub) => $sub->where('co_sos.id', $coSoId));
        }

        if ($request->filled('ngay_trai_nghiem')) {
            $query->whereDate('ngay_trai_nghiem', $request->ngay_trai_nghiem);
        }

        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        $traiNghiems = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        $coSos = CoSo::where('trang_thai', TrangThaiCoSo::ACTIVE)->orderBy('ten')->get();

        return view('trial.index', compact('traiNghiems', 'coSos'));
    }

    public function store(HocVienTraiNghiemRequest $request)
    {
        $data = $request->validated();
        $coSoIds = $data['co_so_ids'] ?? [];
        unset($data['co_so_ids']);

        $traiNghiem = HocVienTraiNghiem::create($data);
        $traiNghiem->coSos()->sync($coSoIds);

        return redirect()->route('trainghiem.index')->with('success', 'Thêm học viên trải nghiệm thành công');
    }

    public function update(HocVienTraiNghiemRequest $request, HocVienTraiNghiem $trainghiem)
    {
        $data = $request->validated();
        $coSoIds = $data['co_so_ids'] ?? [];
        unset($data['co_so_ids']);

        $trainghiem->update($data);
        $trainghiem->coSos()->sync($coSoIds);

        return redirect()->route('trainghiem.index')->with('success', 'Cập nhật học viên trải nghiệm thành công');
    }

    public function destroy(HocVienTraiNghiem $trainghiem)
    {
        if ($trainghiem->trang_thai === TrangThaiLoaiDangKyTraiNghiem::DA_DANG_KY) {
            return redirect()->route('trainghiem.index')->with('error',
                'Không thể xoá: học viên trải nghiệm này đã ở trạng thái "Đã đăng ký".'
            );
        }

        $trainghiem->delete();

        return redirect()->route('trainghiem.index')->with('success', 'Xoá học viên trải nghiệm thành công');
    }
}