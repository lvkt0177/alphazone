<?php

namespace App\Http\Requests\Admin\DiemDanh;

use Illuminate\Foundation\Http\FormRequest;

class DiemDanhBuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hoc_vien_id' => ['required', 'exists:hoc_viens,id'],
            'co_so_id' => ['required', 'exists:co_sos,id'],
            'ngay' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'hoc_vien_id.required' => 'Vui lòng chọn học viên học bù.',
            'hoc_vien_id.exists' => 'Học viên được chọn không tồn tại.',
        ];
    }
}
