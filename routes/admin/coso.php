<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CoSoController;

Route::resource('coso', CoSoController::class)->except(['show', 'create', 'edit'])
    ->middlewareFor('index', 'quyen:coso,xem')
    ->middlewareFor('store', 'quyen:coso,them')
    ->middlewareFor('update', 'quyen:coso,sua')
    ->middlewareFor('destroy', 'quyen:coso,xoa');

Route::patch('/coso/{coso}/trang-thai', [CoSoController::class, 'toggleTrangThai'])
    ->name('coso.trangthai')->middleware('quyen:coso,sua');