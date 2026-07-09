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
            'ho_ten' => ['required', 'string', 'max:255'],
            'ngay_sinh' => ['nullable', 'date'],
            'sdt' => ['nullable', 'string', 'max:15'],
        ];
    }

    public function messages(): array
    {
        return [
            'ho_ten.required' => 'Họ tên không được để trống.',
            'ho_ten.string' => 'Họ tên phải là chuỗi ký tự.',
            'ho_ten.max' => 'Họ tên không được vượt quá 255 ký tự.',
            'ngay_sinh.date' => 'Ngày sinh không đúng định dạng ngày tháng.',
            'sdt.string' => 'Số điện thoại phải là chuỗi ký tự.',
            'sdt.max' => 'Số điện thoại không được vượt quá 15 ký tự.',
        ];
    }
}