<?php

use App\Http\Controllers\Admin\ChamCongController;
use Illuminate\Support\Facades\Route;

Route::get('/chamcong/thay', [ChamCongController::class, 'thay'])->name('chamcong.thay')->middleware('quyen:chamcong,xem');
Route::post('/chamcong/thay', [ChamCongController::class, 'luuThay'])->name('chamcong.thay.luu')->middleware('quyen:chamcong,them');

Route::get('/chamcong/ctv', [ChamCongController::class, 'ctv'])->name('chamcong.ctv')->middleware('quyen:chamcong,xem');
Route::post('/chamcong/ctv/{giaovien}', [ChamCongController::class, 'luuCtv'])->name('chamcong.ctv.luu')->middleware('quyen:chamcong,them');
Route::delete('/chamcong/ctv/{giaovien}', [ChamCongController::class, 'xoaCtv'])->name('chamcong.ctv.xoa')->middleware('quyen:chamcong,xoa');
