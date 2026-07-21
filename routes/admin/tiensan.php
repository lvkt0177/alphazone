<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TienSanController;

Route::resource('tiensan', TienSanController::class)->except(['show', 'create', 'edit']);