<?php

namespace App\Providers;

use App\Models\HocVien;
use App\Models\HocVienTraiNghiem;
use App\Models\ChucNang;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\DiaDiem;
use App\Models\GiaoVien;
use App\Models\SodoMauSac;
use App\Enum\TrangThaiGiaoVien;

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

        View::composer('partials.modals._branch', function ($view) {
            $view->with([
                'diaDiems' => DiaDiem::orderBy('ten')->get(),
                'giaoViens' => GiaoVien::where('trang_thai', TrangThaiGiaoVien::DANG_DAY)->orderBy('ho_ten')->get(),
            ]);
        });

        View::composer('partials.modals._quyengiaovien', function ($view) {
            $view->with([
                'chucNangs' => ChucNang::orderBy('id')->get(),
            ]);
        });

        View::composer('giaoan._sodo_designer', function ($view) {
            $view->with([
                'mauSac' => SodoMauSac::hienTai(),
            ]);
        });
    }
}