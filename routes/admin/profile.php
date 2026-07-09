<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProfileController;

Route::get('doi-mat-khau', [ProfileController::class, 'doiMatKhau'])->name('doi-mat-khau');
Route::post('cap-nhat-mat-khau', [ProfileController::class, 'capNhatMatKhau'])->name('cap-nhat-mat-khau');