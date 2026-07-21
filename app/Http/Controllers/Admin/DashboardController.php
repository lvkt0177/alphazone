<?php

namespace App\Http\Controllers\Admin;

use App\Enum\TrangThaiHocVien;
use App\Http\Controllers\Controller;
use App\Models\CoSo;
use App\Models\HocPhi;
use App\Models\HocVien;
use App\Models\TienSan;

class DashboardController extends Controller
{
    public function index()
    {
        $thangHienTai = now()->startOfMonth();

        $tongHocPhi = HocPhi::where('thang', $thangHienTai->toDateString())->sum('hoc_phi');
        $tongDongPhuc = HocPhi::where('thang', $thangHienTai->toDateString())->sum('dong_phuc');

        $thongKeTrangThai = collect(TrangThaiHocVien::cases())->map(fn ($st) => [
            'label' => $st->getLabel(),
            'badge' => $st->getBadge(),
            'total' => HocVien::where('trang_thai', $st)->count(),
        ]);

        $hocVienDangHoc = HocVien::whereIn('trang_thai', [TrangThaiHocVien::KHACH_HANG, TrangThaiHocVien::QUAY_LAI]);

        $soChuaDong = (clone $hocVienDangHoc)
            ->whereDoesntHave('hocPhis', fn ($q) => $q->where('thang', $thangHienTai->toDateString()))
            ->count();

        $danhSachChuaDong = (clone $hocVienDangHoc)
            ->whereDoesntHave('hocPhis', fn ($q) => $q->where('thang', $thangHienTai->toDateString()))
            ->with('coSos')
            ->orderBy('ho_ten')
            ->limit(6)
            ->get();

        $coSos = CoSo::withCount(['hocViens' => function ($q) {
            $q->whereIn('trang_thai', [TrangThaiHocVien::KHACH_HANG, TrangThaiHocVien::QUAY_LAI]);
        }])->orderBy('ten')->get();

        $bieuDoThang = collect(range(5, 0))->map(function ($i) use ($thangHienTai) {
            $d = (clone $thangHienTai)->subMonths($i);

            return [
                'label' => 'Tháng '.$d->format('n/Y'),
                'hoc_phi' => HocPhi::where('thang', $d->toDateString())->sum('hoc_phi'),
                'dong_phuc' => HocPhi::where('thang', $d->toDateString())->sum('dong_phuc'),
            ];
        });

        $tongTienSan = TienSan::where('ngay', '>=', $thangHienTai->copy()->startOfMonth())
            ->where('ngay', '<=', $thangHienTai->copy()->endOfMonth())
            ->sum('so_tien');

        $tienSanTheoCoSo = CoSo::withSum(['tienSans as tong_tien_san' => function ($q) use ($thangHienTai) {
            $q->where('ngay', '>=', $thangHienTai->copy()->startOfMonth())
                ->where('ngay', '<=', $thangHienTai->copy()->endOfMonth());
        }], 'so_tien')->orderBy('ten')->get();

        return view('dashboard', compact(
            'thangHienTai', 'tongHocPhi', 'tongDongPhuc', 'thongKeTrangThai',
            'soChuaDong', 'danhSachChuaDong', 'coSos', 'bieuDoThang', 'tongTienSan', 'tienSanTheoCoSo'
        ));
    }
}
