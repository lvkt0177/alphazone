<?php

use App\Http\Controllers\Admin\HocVienController;
use Illuminate\Support\Facades\Route;

Route::get('/hoc-vien', [HocVienController::class, 'index'])->name('hocvien.index')->middleware('quyen:hocvien,xem');
Route::get('/hoc-vien/tao-moi-hoc-vien', [HocVienController::class, 'create'])->name('hocvien.create')->middleware('quyen:hocvien,them');
Route::post('/hoc-vien', [HocVienController::class, 'store'])->name('hocvien.store')->middleware('quyen:hocvien,them');
Route::put('/hoc-vien/{hocvien}', [HocVienController::class, 'update'])->name('hocvien.update')->middleware('quyen:hocvien,sua');
Route::delete('/hoc-vien/{hocvien}', [HocVienController::class, 'destroy'])->name('hocvien.destroy')->middleware('quyen:hocvien,xoa');
Route::get('/hoc-vien/{hocvien}', [HocVienController::class, 'show'])->name('hocvien.show')->middleware('quyen:hocvien,xem');
Route::get('/hoc-vien/xuat-ban-ghi/excel', [HocVienController::class, 'export'])->name('hocvien.export')->middleware('quyen:hocvien,xem');
Route::get('/hoc-vien/tao-moi-hoc-vien/goi-y-ma-so', [HocVienController::class, 'goiYMaSo'])->name('hocvien.goiymaso')->middleware('quyen:hocvien,them');
