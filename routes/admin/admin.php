<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    include('giaovien.php');
    include('coso.php');
    include('profile.php');
    include('trainghiem.php');
    include('hocvien.php');
    include('diemdanh.php');
    include('hocphi.php');
    include('tiensan.php');
    include('caidathocphi.php');
    include('giaoan.php');
    include('bieumau.php');
    include('caidattienluong.php');
    include('chamcong.php');
    include('phieuluong.php');
    include('hoadon.php');
    
});