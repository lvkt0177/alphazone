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
            'name' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên tài khoản không được để trống.',
            'name.string' => 'Tên tài khoản phải là chuỗi ký tự.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
        ];
    }

    public function authenticate(): void
    {
        $remember = $this->boolean('remember');

        if (! Auth::attempt($this->only('name', 'password'), $remember)) {
            throw ValidationException::withMessages([
                'name' => 'Tài khoản hoặc mật khẩu không đúng.',
            ]);
        }
    }
}