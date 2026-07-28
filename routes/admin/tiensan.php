<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TienSanController;

Route::resource('tiensan', TienSanController::class)->except(['show', 'create', 'edit'])
    ->middlewareFor('index', 'quyen:tiensan,xem')
    ->middlewareFor('store', 'quyen:tiensan,them')
    ->middlewareFor('update', 'quyen:tiensan,sua')
    ->middlewareFor('destroy', 'quyen:tiensan,xoa');