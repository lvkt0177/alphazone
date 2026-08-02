<?php

namespace App\Http\Requests\Admin\ChamCong;

use Illuminate\Foundation\Http\FormRequest;

class ChamCongThayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ngay' => ['required', 'date', 'before_or_equal:today'],
            'rows' => ['nullable', 'array'],
            'rows.*.co_di_lam' => ['nullable', 'boolean'],
            'rows.*.ho_tro_xang_xe' => ['nullable', 'integer', 'min:0', 'max:999999999'],
            'rows.*.ghi_chu' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'ngay.required' => 'Vui lòng chọn ngày chấm công.',
            'ngay.date' => 'Ngày không đúng định dạng.',
            'ngay.before_or_equal' => 'Không được chấm công cho ngày trong tương lai.',
            'rows.*.ho_tro_xang_xe.integer' => 'Tiền hỗ trợ xăng xe phải là số nguyên.',
            'rows.*.ho_tro_xang_xe.min' => 'Tiền hỗ trợ xăng xe không được âm.',
            'rows.*.ghi_chu.max' => 'Ghi chú không được vượt quá 255 ký tự.',
        ];
    }
}
