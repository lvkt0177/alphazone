<?php

use App\Http\Controllers\Admin\CaiDatTienLuongController;
use Illuminate\Support\Facades\Route;

Route::get('/caidattienluong', [CaiDatTienLuongController::class, 'index'])->name('caidattienluong.index')->middleware('quyen:caidattienluong,xem');
Route::put('/caidattienluong/{giaovien}', [CaiDatTienLuongController::class, 'update'])->name('caidattienluong.update')->middleware('quyen:caidattienluong,sua');
Route::put('/caidattienluong-ngaycong', [CaiDatTienLuongController::class, 'updateNgayCong'])->name('caidattienluong.ngaycong.update')->middleware('quyen:caidattienluong,sua');