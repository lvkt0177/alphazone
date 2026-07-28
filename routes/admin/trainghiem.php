<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HocVienTraiNghiemController;

Route::resource('trainghiem', HocVienTraiNghiemController::class)->except(['show', 'create', 'edit'])
    ->middlewareFor('index', 'quyen:trainghiem,xem')
    ->middlewareFor('store', 'quyen:trainghiem,them')
    ->middlewareFor('update', 'quyen:trainghiem,sua')
    ->middlewareFor('destroy', 'quyen:trainghiem,xoa');