<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }
  
    public function authenticate(): void
    {
        if (! Auth::attempt($this->only('name', 'password'))) {
            throw ValidationException::withMessages([
                'name' => 'Tài khoản hoặc mật khẩu không đúng.',
            ]);
        }
    }
}