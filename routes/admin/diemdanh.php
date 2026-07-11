<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DiemDanhController;

Route::get('/diem-danh', [DiemDanhController::class, 'index'])->name('diemdanh.index');
Route::post('/diem-danh', [DiemDanhController::class, 'store'])->name('diemdanh.store');