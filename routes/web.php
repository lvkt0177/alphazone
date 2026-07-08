<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'web'], function () {

    include('auth/auth.php');

    Route::get('/', function () {
        return redirect()->route('login');
    });

    // Admin
    include('admin/admin.php');

});