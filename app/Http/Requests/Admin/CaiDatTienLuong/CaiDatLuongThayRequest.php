<?php

namespace App\Http\Requests\Admin\CaiDatTienLuong;

use Illuminate\Foundation\Http\FormRequest;

class CaiDatLuongThayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ngay_cong_toi_thieu' => ['required', 'integer', 'min:1', 'max:31'],
            'tien_tru_1_ngay' => ['required', 'integer', 'min:0', 'max:999999999'],
        ];
    }

    public function messages(): array
    {
        return [
            'ngay_cong_toi_thieu.required' => 'Vui lòng nhập số ngày công tối thiểu.',
            'ngay_cong_toi_thieu.integer' => 'Ngày công tối thiểu phải là số nguyên.',
            'ngay_cong_toi_thieu.min' => 'Ngày công tối thiểu phải lớn hơn 0.',
            'ngay_cong_toi_thieu.max' => 'Ngày công tối thiểu không được vượt quá 31.',
            'tien_tru_1_ngay.required' => 'Vui lòng nhập số tiền bị trừ 1 ngày.',
            'tien_tru_1_ngay.integer' => 'Số tiền bị trừ phải là số nguyên.',
            'tien_tru_1_ngay.min' => 'Số tiền bị trừ không được âm.',
        ];
    }
}