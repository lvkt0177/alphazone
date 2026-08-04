<?php

use App\Http\Controllers\Admin\PhieuLuongCtvController;
use App\Http\Controllers\Admin\PhieuLuongNhanVienController;
use Illuminate\Support\Facades\Route;

// Phiếu lương Nhân viên chính thức (Thầy phụ trách)
Route::get('/phieuluong/nhanvien', [PhieuLuongNhanVienController::class, 'index'])->name('phieuluongnhanvien.index')->middleware('quyen:phieuluongnhanvien,xem');
Route::get('/phieuluong/nhanvien/tao', [PhieuLuongNhanVienController::class, 'create'])->name('phieuluongnhanvien.create')->middleware('quyen:phieuluongnhanvien,them');
Route::post('/phieuluong/nhanvien', [PhieuLuongNhanVienController::class, 'store'])->name('phieuluongnhanvien.store')->middleware('quyen:phieuluongnhanvien,them');
Route::get('/phieuluong/nhanvien/{phieu}/sua', [PhieuLuongNhanVienController::class, 'edit'])->name('phieuluongnhanvien.edit')->middleware('quyen:phieuluongnhanvien,sua');
Route::put('/phieuluong/nhanvien/{phieu}', [PhieuLuongNhanVienController::class, 'update'])->name('phieuluongnhanvien.update')->middleware('quyen:phieuluongnhanvien,sua');
Route::delete('/phieuluong/nhanvien/{phieu}', [PhieuLuongNhanVienController::class, 'destroy'])->name('phieuluongnhanvien.destroy')->middleware('quyen:phieuluongnhanvien,xoa');
Route::get('/phieuluong/nhanvien-xuat-excel', [PhieuLuongNhanVienController::class, 'xuatExcel'])->name('phieuluongnhanvien.xuatexcel')->middleware('quyen:phieuluongnhanvien,xem');

// Phiếu lương Cộng tác viên
Route::get('/phieuluong/ctv', [PhieuLuongCtvController::class, 'index'])->name('phieuluongctv.index')->middleware('quyen:phieuluongctv,xem');
Route::get('/phieuluong/ctv/tao', [PhieuLuongCtvController::class, 'create'])->name('phieuluongctv.create')->middleware('quyen:phieuluongctv,them');
Route::post('/phieuluong/ctv', [PhieuLuongCtvController::class, 'store'])->name('phieuluongctv.store')->middleware('quyen:phieuluongctv,them');
Route::get('/phieuluong/ctv/{phieu}/sua', [PhieuLuongCtvController::class, 'edit'])->name('phieuluongctv.edit')->middleware('quyen:phieuluongctv,sua');
Route::put('/phieuluong/ctv/{phieu}', [PhieuLuongCtvController::class, 'update'])->name('phieuluongctv.update')->middleware('quyen:phieuluongctv,sua');
Route::delete('/phieuluong/ctv/{phieu}', [PhieuLuongCtvController::class, 'destroy'])->name('phieuluongctv.destroy')->middleware('quyen:phieuluongctv,xoa');
Route::get('/phieuluong/ctv-xuat-excel', [PhieuLuongCtvController::class, 'xuatExcel'])->name('phieuluongctv.xuatexcel')->middleware('quyen:phieuluongctv,xem');