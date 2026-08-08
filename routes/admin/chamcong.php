<?php

use App\Http\Controllers\Admin\ChamCongController;
use Illuminate\Support\Facades\Route;

Route::get('/chamcong', [ChamCongController::class, 'index'])->name('chamcong.index')->middleware('quyen:chamcong,xem');
Route::post('/chamcong/luu-hang-loat', [ChamCongController::class, 'luuHangLoat'])->name('chamcong.luuhangloat')->middleware('quyen:chamcong,them');
Route::delete('/chamcong/{chamcong}', [ChamCongController::class, 'xoa'])->name('chamcong.xoa')->middleware('quyen:chamcong,xoa');