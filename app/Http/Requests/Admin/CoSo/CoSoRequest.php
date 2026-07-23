<?php

namespace App\Http\Requests\Admin\CoSo;

use Illuminate\Foundation\Http\FormRequest;

class CoSoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ten' => ['required', 'string', 'max:255'],
            'giao_vien_id' => ['nullable', 'exists:giao_viens,id'],
            'dia_diem_id' => ['nullable', 'string'],
            'dia_diem_ten_moi' => ['nullable', 'string', 'max:255', 'required_if:dia_diem_id,new'],
        ];
    }

    public function messages(): array
    {
        return [
            'ten.required' => 'Tên cơ sở không được để trống.',
            'ten.string' => 'Tên cơ sở phải là chuỗi ký tự.',
            'ten.max' => 'Tên cơ sở không được vượt quá 255 ký tự.',
            // 'giao_vien_id.required' => 'Vui lòng chọn giáo viên phụ trách.',
            'giao_vien_id.exists' => 'Giáo viên được chọn không tồn tại trên hệ thống.',
            'dia_diem_ten_moi.required_if' => 'Vui lòng nhập tên Địa điểm mới.',
        ];
    }
}
