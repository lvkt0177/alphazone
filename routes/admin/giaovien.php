<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GiaoVienController;

Route::resource('giaovien', GiaoVienController::class)->except(['show', 'create', 'edit']);