<?php

namespace App\Http\Requests\Admin\PhieuLuong;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PhieuLuongNhanVienRequest extends FormRequest
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
            'ngay_chot' => ['nullable', 'date'],
            'ngay_cong_chuan' => ['nullable', 'integer', 'min:1', 'max:31'],
            'tro_cap' => ['nullable', 'integer', 'min:0'],
            'nang_suat' => ['nullable', 'integer', 'min:0'],
            'thuong_khac' => ['nullable', 'integer', 'min:0'],
            'cong_tac_phi' => ['nullable', 'integer', 'min:0'],
            'tam_ung' => ['nullable', 'integer', 'min:0'],
            'giam_tru_gia_canh' => ['nullable', 'integer', 'min:0'],
            'thue_tncn' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'giao_vien_id.required' => 'Vui lòng chọn giáo viên.',
            'giao_vien_id.exists' => 'Giáo viên không hợp lệ.',
            'thang.required' => 'Vui lòng chọn tháng.',
            'thang.date_format' => 'Tháng không đúng định dạng.',
        ];
    }
}