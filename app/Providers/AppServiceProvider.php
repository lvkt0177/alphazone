<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\HocVienTraiNghiem;
use App\Models\HocVien;
use App\Enum\TrangThaiLoaiDangKyTraiNghiem;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.admin', function ($view) {
            $countTraiNghiem = HocVienTraiNghiem::count();
            $countHocVien = HocVien::count();

            $thangHienTai = Carbon::now()->startOfMonth()->toDateString();
            $countHocVienChuaDongHocPhi = HocVien::whereDoesntHave(
                'hocPhis',
                fn ($q) => $q->where('thang', $thangHienTai)
            )->count();

            $view->with([
                'countTraiNghiem' => $countTraiNghiem,
                'countHocVien' => $countHocVien,
                'countHocVienChuaDongHocPhi' => $countHocVienChuaDongHocPhi,
            ]);
        });
    }
}