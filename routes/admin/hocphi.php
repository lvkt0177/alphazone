<?php

use App\Http\Controllers\Admin\HocPhiController;
use Illuminate\Support\Facades\Route;

Route::get('/hoc-phi', [HocPhiController::class, 'index'])->name('hocphi.index')->middleware('quyen:hocphi,xem');
Route::post('/hoc-phi', [HocPhiController::class, 'store'])->name('hocphi.store')->middleware('quyen:hocphi,them');
Route::delete('hocphi', [HocPhiController::class, 'destroy'])->name('hocphi.destroy')->middleware('quyen:hocphi,xoa');
Route::delete('hoc-phi/dot/{hocPhi}', [HocPhiController::class, 'xoaDot'])->name('hocphi.destroyDot')->middleware('quyen:hocphi,xoa');