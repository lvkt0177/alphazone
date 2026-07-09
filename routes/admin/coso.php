<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CoSoController;

Route::resource('coso', CoSoController::class)->except(['show', 'create', 'edit']);
Route::patch('/coso/{coso}/trang-thai', [CoSoController::class, 'toggleTrangThai'])->name('coso.trangthai');