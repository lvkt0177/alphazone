<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DiemDanhController;

Route::get('/diem-danh', [DiemDanhController::class, 'index'])->name('diemdanh.index')->middleware('quyen:diemdanh,xem');
Route::post('/diem-danh', [DiemDanhController::class, 'store'])->name('diemdanh.store')->middleware('quyen:diemdanh,them');
Route::post('/diem-danh/hoc-bu', [DiemDanhController::class, 'themHocBu'])->name('diemdanh.hocbu')->middleware('quyen:diemdanh,them');
Route::delete('/diem-danh/hoc-bu/{diemdanh}', [DiemDanhController::class, 'xoaHocBu'])->name('diemdanh.hocbu.destroy')->middleware('quyen:diemdanh,xoa');
Route::delete('/diem-danh', [DiemDanhController::class, 'xoaTatCa'])->name('diemdanh.destroyAll')->middleware('quyen:diemdanh,xoa');