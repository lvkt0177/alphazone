<?php

namespace App\Http\Controllers\Admin;

use App\Enum\ChucDanhGiaoVien;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CaiDatTienLuong\CaiDatTienLuongRequest;
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

        return view('caidat.tienluong.index', compact('thayPhuTrachs', 'ctvHoTros'));
    }

    public function update(CaiDatTienLuongRequest $request, GiaoVien $giaovien)
    {
        $ten = $giaovien->chuc_danh === ChucDanhGiaoVien::THAY_PHU_TRACH ? 'luong_co_ban' : 'don_gia_gio';

        $giaovien->update([$ten => $request->validated()[$ten]]);

        return redirect()->route('caidattienluong.index')->with('success', 'Cập nhật thành công');
    }
}