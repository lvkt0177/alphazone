<?php

namespace App\Http\Requests\Admin\GiaoVien;

use Illuminate\Foundation\Http\FormRequest;

class GiaoVienRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ho_ten'    => ['required', 'string', 'max:255'],
            'ngay_sinh' => ['nullable', 'date'],
            'sdt'       => ['nullable', 'string', 'max:15'],
        ];
    }
}