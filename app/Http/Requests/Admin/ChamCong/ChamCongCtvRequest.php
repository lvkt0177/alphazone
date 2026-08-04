<?php

namespace App\Http\Requests\Admin\ChamCong;

use Illuminate\Foundation\Http\FormRequest;

class ChamCongCtvRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ngay' => ['required', 'date', 'before_or_equal:today'],
            'so_gio' => ['required', 'numeric', 'min:0', 'max:24'],
            'ho_tro_xang_xe' => ['nullable', 'integer', 'min:0', 'max:999999999'],
            'ghi_chu' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'ngay.required' => 'Vui lòng chọn ngày chấm công.',
            'ngay.date' => 'Ngày không đúng định dạng.',
            'ngay.before_or_equal' => 'Không được chấm công cho ngày trong tương lai.',
            'so_gio.required' => 'Vui lòng nhập số giờ (cho phép nhập 0).',
            'so_gio.numeric' => 'Số giờ phải là số.',
            'so_gio.min' => 'Số giờ không được âm.',
            'so_gio.max' => 'Số giờ không được vượt quá 24.',
            'ho_tro_xang_xe.integer' => 'Tiền hỗ trợ xăng xe phải là số nguyên.',
            'ho_tro_xang_xe.min' => 'Tiền hỗ trợ xăng xe không được âm.',
            'ghi_chu.max' => 'Ghi chú không được vượt quá 255 ký tự.',
        ];
    }
}
