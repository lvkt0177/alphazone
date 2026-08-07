<?php

use App\Http\Controllers\Admin\HoaDonController;
use Illuminate\Support\Facades\Route;

Route::get('/hoadon/dau-vao', [HoaDonController::class, 'menuDauVao'])->name('hoadon.dauvao.menu')->middleware('quyen:hoadon,xem');
Route::get('/hoadon/dau-vao/{loai}', [HoaDonController::class, 'indexDauVao'])->name('hoadon.dauvao.index')->middleware('quyen:hoadon,xem')->where('loai', '[0-9]+');
Route::post('/hoadon/dau-vao/{loai}', [HoaDonController::class, 'storeDauVao'])->name('hoadon.dauvao.store')->middleware('quyen:hoadon,them')->where('loai', '[0-9]+');
Route::put('/hoadon/dau-vao/item/{hoadon}', [HoaDonController::class, 'updateDauVao'])->name('hoadon.dauvao.update')->middleware('quyen:hoadon,sua');
Route::get('/hoadon/dau-vao/item/{hoadon}/tai', [HoaDonController::class, 'downloadDauVao'])->name('hoadon.dauvao.download')->middleware('quyen:hoadon,xem');
Route::delete('/hoadon/dau-vao/item/{hoadon}', [HoaDonController::class, 'destroyDauVao'])->name('hoadon.dauvao.destroy')->middleware('quyen:hoadon,xoa');

Route::get('/hoadon/dau-ra', [HoaDonController::class, 'dauRa'])->name('hoadon.daura.index')->middleware('quyen:hoadon,xem');
