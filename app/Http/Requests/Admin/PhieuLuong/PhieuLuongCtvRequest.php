<?php

namespace App\Http\Requests\Admin\PhieuLuong;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PhieuLuongCtvRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $dangSua = (bool) $this->route('phieu');

        return [
            'giao_vien_id' => [
                $dangSua ? 'nullable' : 'required',
                'integer',
                Rule::exists('giao_viens', 'id'),
            ],
            'thang' => ['required', 'date_format:Y-m'],
            'khau_tru' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'giao_vien_id.required' => 'Vui lòng chọn cộng tác viên.',
            'giao_vien_id.exists' => 'Cộng tác viên không hợp lệ.',
            'thang.required' => 'Vui lòng chọn tháng.',
            'thang.date_format' => 'Tháng không đúng định dạng.',
        ];
    }
}