<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GiaoAnMenuController;
use App\Http\Controllers\Admin\GiaoAnController;

Route::get('/giaoan', [GiaoAnMenuController::class, 'index'])->name('giaoan.menu')->middleware('quyen:giaoan,xem');

Route::get('/giaoan/danh-sach', [GiaoAnController::class, 'index'])->name('giaoan.index')->middleware('quyen:giaoan,xem');
Route::get('/giaoan/tao-moi', [GiaoAnController::class, 'create'])->name('giaoan.create')->middleware('quyen:giaoan,them');
Route::post('/giaoan', [GiaoAnController::class, 'store'])->name('giaoan.store')->middleware('quyen:giaoan,them');
Route::get('/giaoan/{giaoan}/sua', [GiaoAnController::class, 'edit'])->name('giaoan.edit')->middleware('quyen:giaoan,sua');
Route::put('/giaoan/{giaoan}', [GiaoAnController::class, 'update'])->name('giaoan.update')->middleware('quyen:giaoan,sua');
Route::delete('/giaoan/{giaoan}', [GiaoAnController::class, 'destroy'])->name('giaoan.destroy')->middleware('quyen:giaoan,xoa');