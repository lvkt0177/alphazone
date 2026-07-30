<?php

use App\Http\Controllers\Admin\GiaoVienController;
use Illuminate\Support\Facades\Route;

Route::resource('giaovien', GiaoVienController::class)->except(['show', 'create', 'edit'])
    ->middlewareFor('index', 'quyen:giaovien,xem')
    ->middlewareFor('store', 'quyen:giaovien,them')
    ->middlewareFor('update', 'quyen:giaovien,sua')
    ->middlewareFor('destroy', 'quyen:giaovien,xoa');

Route::patch('/giaovien/{giaovien}/trang-thai', [GiaoVienController::class, 'toggleTrangThai'])
    ->name('giaovien.trangthai')->middleware('quyen:giaovien,sua');
Route::post('/giaovien/{giaovien}/tai-khoan', [GiaoVienController::class, 'capTaiKhoan'])
    ->name('giaovien.captaikhoan')->middleware('quyen:giaovien,them');
Route::post('/giaovien/{giaovien}/quyen', [GiaoVienController::class, 'luuQuyen'])
    ->name('giaovien.luuquyen')->middleware('quyen:giaovien,sua');
Route::post('/giaovien/{giaovien}/doi-mat-khau', [GiaoVienController::class, 'doiMatKhauTaiKhoan'])
    ->name('giaovien.doimatkhau')->middleware('quyen:giaovien,sua');
