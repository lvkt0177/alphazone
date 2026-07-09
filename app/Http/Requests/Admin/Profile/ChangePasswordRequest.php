<?php

namespace App\Http\Requests\Admin\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'new_password' => [
                'required',
                'string',
                Password::min(1)
            ],
            'new_password_confirmation' => ['required', 'same:new_password'],
        ];  
    }

    public function messages()
    {
        return [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'current_password.current_password' => 'Mật khẩu hiện tại không đúng.',
    
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'new_password.letters' => 'Mật khẩu mới phải chứa ít nhất một chữ cái.',
            'new_password.mixedCase' => 'Mật khẩu mới phải bao gồm cả chữ hoa và chữ thường.',
            'new_password.numbers' => 'Mật khẩu mới phải chứa ít nhất một số.',
            'new_password.symbols' => 'Mật khẩu mới phải chứa ít nhất một ký tự đặc biệt.',
    
            'new_password_confirmation.required' => 'Vui lòng xác nhận mật khẩu mới.',
            'new_password_confirmation.same' => 'Xác nhận mật khẩu không khớp.',
        ];
    }



   
}
