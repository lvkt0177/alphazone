<?php

use App\Http\Controllers\Admin\HocPhiController;
use Illuminate\Support\Facades\Route;

Route::get('/hoc-phi', [HocPhiController::class, 'index'])->name('hocphi.index');
Route::post('/hoc-phi', [HocPhiController::class, 'store'])->name('hocphi.store');
Route::delete('hocphi', [HocPhiController::class, 'destroy'])->name('hocphi.destroy');