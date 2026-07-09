<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HocVienTraiNghiemController;

Route::resource('trainghiem', HocVienTraiNghiemController::class)->except(['show', 'create', 'edit']);