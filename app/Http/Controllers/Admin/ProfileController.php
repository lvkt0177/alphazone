<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Admin\Profile\ChangePasswordRequest;

class ProfileController extends Controller
{
    public function index()
    {
        //
    }

    public function doiMatKhau()
    {
        return view('account.index');
    }

    public function capNhatMatKhau(ChangePasswordRequest $request)
    {
        $user = auth()->user();
        $user->password = bcrypt($request->new_password);
        $user->save();
        
        return redirect()->route('doi-mat-khau')->with('success', 'Đổi mật khẩu thành công!');
    }
    
}