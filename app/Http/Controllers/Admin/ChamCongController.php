<?php

namespace App\Http\Controllers\Admin;

use App\Enum\ChucDanhGiaoVien;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChamCong\ChamCongHangLoatRequest;
use App\Models\ChamCongGiaoVien;
use App\Models\GiaoVien;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChamCongController extends Controller
{
    public function index(Request $request)
    {
        $thangInput = $request->input('thang') ?: now()->format('Y-m');
        $thang = Carbon::createFromFormat('Y-m', $thangInput)->startOfMonth();

        $thayPhuTrachs = GiaoVien::where('chuc_danh', ChucDanhGiaoVien::THAY_PHU_TRACH->value)
            ->orderBy('ho_ten')
            ->get();

        $ctvs = GiaoVien::where('chuc_danh', ChucDanhGiaoVien::TRO_GIANG->value)
            ->orderBy('ho_ten')
            ->get();

        $banGhiThang = ChamCongGiaoVien::with('giaoVien')
            ->whereBetween('ngay', [$thang->toDateString(), $thang->copy()->endOfMonth()->toDateString()])
            ->get()
            ->groupBy(fn ($r) => $r->ngay->toDateString());

        $homNay = now()->toDateString();
        $ngayTrongThang = [];

        for ($d = $thang->copy(); $d->month === $thang->month; $d->addDay()) {
            $ngayIso = $d->toDateString();
            $banGhi = $banGhiThang->get($ngayIso, collect());

            $ngayTrongThang[] = [
                'ngay' => $d->copy(),
                'la_tuong_lai' => $ngayIso > $homNay,
                'ban_ghi_thay' => $banGhi->filter(fn ($r) => $r->giaoVien?->chuc_danh === ChucDanhGiaoVien::THAY_PHU_TRACH)->values(),
                'ban_ghi_ctv' => $banGhi->filter(fn ($r) => $r->giaoVien?->chuc_danh === ChucDanhGiaoVien::TRO_GIANG)->values(),
            ];
        }

        return view('chamcong.index', compact('thang', 'ngayTrongThang', 'thayPhuTrachs', 'ctvs'));
    }

    public function luuHangLoat(ChamCongHangLoatRequest $request)
    {
        $ngay = $request->ngay;
        $rows = $request->input('rows', []);

        foreach ($rows as $row) {
            $giaoVien = GiaoVien::find($row['giao_vien_id']);

            if (! $giaoVien) {
                continue;
            }

            if ($row['loai'] === 'ctv') {
                if ($giaoVien->don_gia_gio === null) {
                    return redirect()->route('chamcong.index', ['thang' => Carbon::parse($ngay)->format('Y-m')])
                        ->with('error', 'Giáo viên '.$giaoVien->ho_ten.' chưa được cấu hình Đơn giá/giờ. Vui lòng vào Cài đặt Tiền lương để thiết lập trước khi chấm công.');
                }

                ChamCongGiaoVien::updateOrCreate(
                    ['giao_vien_id' => $giaoVien->id, 'ngay' => $ngay],
                    [
                        'co_di_lam' => null,
                        'so_gio' => $row['so_gio'] ?? 0,
                        'ho_tro_xang_xe' => $row['ho_tro_xang_xe'] ?? null,
                        'ghi_chu' => $row['ghi_chu'] ?? null,
                        'updated_by_user_id' => auth()->id(),
                    ]
                );
            } else {
                ChamCongGiaoVien::updateOrCreate(
                    ['giao_vien_id' => $giaoVien->id, 'ngay' => $ngay],
                    [
                        'co_di_lam' => (bool) ($row['co_di_lam'] ?? false),
                        'so_gio' => null,
                        'ho_tro_xang_xe' => null,
                        'ghi_chu' => $row['ghi_chu'] ?? null,
                        'updated_by_user_id' => auth()->id(),
                    ]
                );
            }
        }

        return redirect()->route('chamcong.index', ['thang' => Carbon::parse($ngay)->format('Y-m')])
            ->with('success', 'Lưu chấm công thành công');
    }

    public function xoa(ChamCongGiaoVien $chamcong)
    {
        $thang = $chamcong->ngay->format('Y-m');
        $chamcong->delete();

        return redirect()->route('chamcong.index', ['thang' => $thang])->with('success', 'Đã xoá chấm công');
    }
}