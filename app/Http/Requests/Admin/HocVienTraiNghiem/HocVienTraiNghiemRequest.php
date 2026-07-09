<?php

namespace App\Http\Requests\Admin\HocVienTraiNghiem;

use Illuminate\Foundation\Http\FormRequest;
use App\Enum\TrangThaiLoaiDangKyTraiNghiem;
use Illuminate\Validation\Rule;

class HocVienTraiNghiemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ho_ten' => ['required', 'string', 'max:255'],
            'nam_sinh' => ['nullable', 'integer', 'min:1990', 'max:' . date('Y')],
            'trang_thai' => ['required', Rule::enum(TrangThaiLoaiDangKyTraiNghiem::class)],
            'ghi_chu' => ['nullable', 'string'],
            'co_so_ids' => ['nullable', 'array'],
            'co_so_ids.*' => ['exists:co_sos,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'ho_ten.required' => 'Họ tên không được để trống.',
            'ho_ten.string' => 'Họ tên phải là chuỗi ký tự.',
            'ho_ten.max' => 'Họ tên không được vượt quá 255 ký tự.',
            'nam_sinh.integer' => 'Năm sinh phải là một số nguyên.',
            'nam_sinh.min' => 'Năm sinh không được nhỏ hơn năm 1990.',
            'nam_sinh.max' => 'Năm sinh không được lớn hơn năm hiện tại.',
            'trang_thai.required' => 'Trạng thái không được để trống.',
            'trang_thai.Illuminate\Validation\Rules\Enum' => 'Trạng thái chọn không hợp lệ.',
            'ghi_chu.string' => 'Ghi chú phải là chuỗi ký tự.',
            'co_so_ids.array' => 'Danh sách cơ sở phải là một mảng.',
            'co_so_ids.*.exists' => 'Cơ sở được chọn không tồn tại trên hệ thống.',
        ];
    }
}