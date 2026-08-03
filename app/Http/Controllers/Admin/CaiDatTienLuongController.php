<?php

namespace App\Http\Controllers\Admin;

use App\Enum\ChucDanhGiaoVien;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CaiDatTienLuong\CaiDatLuongThayRequest;
use App\Http\Requests\Admin\CaiDatTienLuong\CaiDatTienLuongRequest;
use App\Models\CaiDatLuongThay;
use App\Models\GiaoVien;

class CaiDatTienLuongController extends Controller
{
    public function index()
    {
        $thayPhuTrachs = GiaoVien::where('chuc_danh', ChucDanhGiaoVien::THAY_PHU_TRACH->value)
            ->orderBy('ho_ten')
            ->get();

        $ctvHoTros = GiaoVien::where('chuc_danh', ChucDanhGiaoVien::TRO_GIANG->value)
            ->orderBy('ho_ten')
            ->get();

        $caiDatLuongThay = CaiDatLuongThay::hienTai();

        return view('caidat.tienluong.index', compact('thayPhuTrachs', 'ctvHoTros', 'caiDatLuongThay'));
    }

    public function update(CaiDatTienLuongRequest $request, GiaoVien $giaovien)
    {
        $ten = $giaovien->chuc_danh === ChucDanhGiaoVien::THAY_PHU_TRACH ? 'luong_co_ban' : 'don_gia_gio';

        $giaovien->update([$ten => $request->validated()[$ten]]);

        return redirect()->route('caidattienluong.index')->with('success', 'Cập nhật thành công');
    }

    public function updateNgayCong(CaiDatLuongThayRequest $request)
    {
        CaiDatLuongThay::luu($request->ngay_cong_toi_thieu, $request->tien_tru_1_ngay);

        return redirect()->route('caidattienluong.index')->with('success', 'Cập nhật cấu hình ngày công thành công');
    }
}