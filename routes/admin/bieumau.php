<?php

use App\Http\Controllers\Admin\BieuMauController;
use Illuminate\Support\Facades\Route;

Route::get('/bieumau', [BieuMauController::class, 'menu'])->name('bieumau.menu')->middleware('quyen:bieumau,xem');
Route::get('/bieumau/{loai}', [BieuMauController::class, 'index'])->name('bieumau.index')->middleware('quyen:bieumau,xem')->where('loai', '[0-9]+');
Route::post('/bieumau/{loai}', [BieuMauController::class, 'store'])->name('bieumau.store')->middleware('quyen:bieumau,them')->where('loai', '[0-9]+');
Route::put('/bieumau/{bieumau}', [BieuMauController::class, 'update'])->name('bieumau.update')->middleware('quyen:bieumau,sua');
Route::delete('/bieumau/{bieumau}', [BieuMauController::class, 'destroy'])->name('bieumau.destroy')->middleware('quyen:bieumau,xoa');