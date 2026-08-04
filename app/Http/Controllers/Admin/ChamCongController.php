<?php

namespace App\Http\Controllers\Admin;

use App\Enum\ChucDanhGiaoVien;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChamCong\ChamCongCtvRequest;
use App\Http\Requests\Admin\ChamCong\ChamCongThayRequest;
use App\Models\ChamCongGiaoVien;
use App\Models\GiaoVien;
use Illuminate\Http\Request;

class ChamCongController extends Controller
{
    private function ngayHopLe(?string $ngay): string
    {
        $homNay = now()->toDateString();
        $ngay = $ngay ?: $homNay;

        return $ngay > $homNay ? $homNay : $ngay;
    }

    public function thay(Request $request)
    {
        $ngay = $this->ngayHopLe($request->input('ngay'));

        $thayPhuTrachs = GiaoVien::where('chuc_danh', ChucDanhGiaoVien::THAY_PHU_TRACH->value)
            ->orderBy('ho_ten')
            ->get();

        $existing = ChamCongGiaoVien::whereIn('giao_vien_id', $thayPhuTrachs->pluck('id'))
            ->where('ngay', $ngay)
            ->get()
            ->keyBy('giao_vien_id');

        $soCo = $existing->where('co_di_lam', true)->count();
        $soKhong = $existing->where('co_di_lam', false)->count();

        return view('chamcong.thay', compact('thayPhuTrachs', 'existing', 'ngay', 'soCo', 'soKhong'));
    }

    public function luuThay(ChamCongThayRequest $request)
    {
        $ngay = $request->ngay;
        $rows = $request->input('rows', []);

        $thayIds = GiaoVien::where('chuc_danh', ChucDanhGiaoVien::THAY_PHU_TRACH->value)->pluck('id');

        foreach ($thayIds as $giaoVienId) {
            $row = $rows[$giaoVienId] ?? [];

            $coDiLam = $row['co_di_lam'] ?? null;
            $hoTro = $row['ho_tro_xang_xe'] ?? null;
            $ghiChu = $row['ghi_chu'] ?? null;

            $coDiLam = ($coDiLam === null || $coDiLam === '') ? null : (bool) $coDiLam;
            $trong = $coDiLam === null && $hoTro === null && ($ghiChu === null || $ghiChu === '');

            if ($trong) {
                ChamCongGiaoVien::where('giao_vien_id', $giaoVienId)->where('ngay', $ngay)->delete();

                continue;
            }

            ChamCongGiaoVien::updateOrCreate(
                ['giao_vien_id' => $giaoVienId, 'ngay' => $ngay],
                [
                    'co_di_lam' => $coDiLam,
                    'ho_tro_xang_xe' => $hoTro,
                    'ghi_chu' => $ghiChu,
                    'updated_by_user_id' => auth()->id(),
                ]
            );
        }

        return redirect()->route('chamcong.thay', ['ngay' => $ngay])->with('success', 'Lưu chấm công thành công');
    }

    public function ctv(Request $request)
    {
        $ngay = $this->ngayHopLe($request->input('ngay'));

        $ctvs = GiaoVien::where('chuc_danh', ChucDanhGiaoVien::TRO_GIANG->value)
            ->orderBy('ho_ten')
            ->get();

        $existing = ChamCongGiaoVien::whereIn('giao_vien_id', $ctvs->pluck('id'))
            ->where('ngay', $ngay)
            ->get()
            ->keyBy('giao_vien_id');

        $soDaCham = $existing->count();

        return view('chamcong.ctv', compact('ctvs', 'existing', 'ngay', 'soDaCham'));
    }

    public function luuCtv(ChamCongCtvRequest $request, GiaoVien $giaovien)
    {
        abort_unless($giaovien->chuc_danh === ChucDanhGiaoVien::TRO_GIANG, 404);

        if ($giaovien->don_gia_gio === null) {
            return redirect()->route('chamcong.ctv', ['ngay' => $request->ngay])->with(
                'error',
                'Giáo viên '.$giaovien->ho_ten.' chưa được cấu hình Đơn giá/giờ. Vui lòng vào Cài đặt Tiền lương để thiết lập trước khi chấm công.'
            );
        }

        ChamCongGiaoVien::updateOrCreate(
            ['giao_vien_id' => $giaovien->id, 'ngay' => $request->ngay],
            [
                'so_gio' => $request->so_gio,
                'ho_tro_xang_xe' => $request->ho_tro_xang_xe,
                'ghi_chu' => $request->ghi_chu,
                'updated_by_user_id' => auth()->id(),
            ]
        );

        return redirect()->route('chamcong.ctv', ['ngay' => $request->ngay])->with('success', 'Lưu chấm công thành công');
    }

    public function xoaCtv(Request $request, GiaoVien $giaovien)
    {
        $ngay = $this->ngayHopLe($request->input('ngay'));

        ChamCongGiaoVien::where('giao_vien_id', $giaovien->id)->where('ngay', $ngay)->delete();

        return redirect()->route('chamcong.ctv', ['ngay' => $ngay])->with('success', 'Đã xoá chấm công');
    }
}