<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CaiDatHocPhiController;

Route::resource('caidathocphi', CaiDatHocPhiController::class)->except(['show', 'create', 'edit'])
    ->middlewareFor('index', 'quyen:caidathocphi,xem')
    ->middlewareFor('store', 'quyen:caidathocphi,them')
    ->middlewareFor('update', 'quyen:caidathocphi,sua')
    ->middlewareFor('destroy', 'quyen:caidathocphi,xoa');