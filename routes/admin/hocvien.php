<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HocVienController;

Route::get('/hoc-vien', [HocVienController::class, 'index'])->name('hocvien.index');
Route::get('/hoc-vien/tao-moi-hoc-vien', [HocVienController::class, 'create'])->name('hocvien.create');
Route::post('/hoc-vien', [HocVienController::class, 'store'])->name('hocvien.store');
Route::put('/hoc-vien/{hocvien}', [HocVienController::class, 'update'])->name('hocvien.update');
Route::delete('/hoc-vien/{hocvien}', [HocVienController::class, 'destroy'])->name('hocvien.destroy');
Route::get('/hoc-vien/{hocvien}', [HocVienController::class, 'show'])->name('hocvien.show');
Route::get('/hoc-vien/xuat-ban-ghi/excel', [HocVienController::class, 'export'])->name('hocvien.export');