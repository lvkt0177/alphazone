<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CaiDatHocPhiController;

Route::resource('caidathocphi', CaiDatHocPhiController::class)->except(['show', 'create', 'edit']);