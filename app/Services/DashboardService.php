<?php

namespace App\Services;

use App\Enum\TrangThaiHocVien;
use App\Models\CoSo;
use App\Models\DiaDiem;
use App\Models\HocPhi;
use App\Models\HocVien;
use App\Models\HocVienTraiNghiem;
use App\Models\TienSan;
use Carbon\Carbon;

class DashboardService
{
    public function __construct(
        protected Carbon $thangHienTai = new Carbon
    ) {
        $this->thangHienTai = now()->startOfMonth();
    }

    public function layDuLieuTongQuan(): array
    {
        return [
            'thangHienTai' => $this->thangHienTai,
            'tongHocPhi' => $this->tongHocPhiThang(),
            'tongDongPhuc' => $this->tongDongPhucThang(),
            'thongKeTrangThai' => $this->thongKeTrangThaiHocVien(),
            'soChuaDong' => $this->soHocVienChuaDong(),
            'danhSachChuaDong' => $this->danhSachHocVienChuaDong(),
            'coSos' => $this->soLuongHocVienTheoCoSo(),
            'traiNghiemHomNay' => $this->danhSachTraiNghiemHomNay(),
            'tongTienSan' => $this->tongTienSanThang(),
            'tienSanTheoDiaDiem' => $this->tienSanTheoDiaDiem(),
        ];
    }

    private function tongHocPhiThang(): int
    {
        return HocPhi::where('thang', $this->thangHienTai->toDateString())->sum('hoc_phi');
    }

    private function tongDongPhucThang(): int
    {
        return HocPhi::where('thang', $this->thangHienTai->toDateString())->sum('dong_phuc');
    }

    private function thongKeTrangThaiHocVien()
    {
        return collect(TrangThaiHocVien::cases())->map(fn ($st) => [
            'label' => $st->getLabel(),
            'badge' => $st->getBadge(),
            'total' => HocVien::where('trang_thai', $st)->count(),
        ]);
    }

    private function hocVienDangHocQuery()
    {
        return HocVien::whereIn('trang_thai', [TrangThaiHocVien::KHACH_HANG, TrangThaiHocVien::QUAY_LAI]);
    }

    private function soHocVienChuaDong(): int
    {
        return $this->hocVienDangHocQuery()
            ->whereDoesntHave('hocPhis', fn ($q) => $q->where('thang', $this->thangHienTai->toDateString()))
            ->count();
    }

    private function danhSachHocVienChuaDong()
    {
        return $this->hocVienDangHocQuery()
            ->whereDoesntHave('hocPhis', fn ($q) => $q->where('thang', $this->thangHienTai->toDateString()))
            ->with('coSos')
            ->orderBy('ho_ten')
            ->limit(6)
            ->get();
    }

    private function soLuongHocVienTheoCoSo()
    {
        return CoSo::withCount(['hocViens' => function ($q) {
            $q->whereIn('trang_thai', [TrangThaiHocVien::KHACH_HANG, TrangThaiHocVien::QUAY_LAI]);
        }])->orderBy('ten')->get();
    }

    private function danhSachTraiNghiemHomNay()
    {
        return HocVienTraiNghiem::where('ngay_trai_nghiem', now()->toDateString())
            ->with('coSos')
            ->orderBy('ho_ten')
            ->get();
    }

    private function tongTienSanThang(): int
    {
        return TienSan::whereBetween('ngay', [
            $this->thangHienTai->copy()->startOfMonth(),
            $this->thangHienTai->copy()->endOfMonth(),
        ])->sum('so_tien');
    }

    private function tienSanTheoDiaDiem()
    {
        $khoangThang = [
            $this->thangHienTai->copy()->startOfMonth(),
            $this->thangHienTai->copy()->endOfMonth(),
        ];

        return DiaDiem::with(['coSos' => function ($q) use ($khoangThang) {
            $q->withSum(['tienSans as tong_tien_san' => fn ($sub) => $sub->whereBetween('ngay', $khoangThang)], 'so_tien')
                ->orderBy('ten');
        }])
            ->withSum(['tienSans as tong_tien_san' => fn ($q) => $q->whereBetween('ngay', $khoangThang)], 'so_tien')
            ->orderBy('ten')
            ->get();
    }
}