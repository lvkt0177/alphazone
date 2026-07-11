<?php

namespace App\Http\Requests\Admin\DiemDanh;

use Illuminate\Foundation\Http\FormRequest;
use App\Enum\TrangThaiDiemDanh;
use Illuminate\Validation\Rule;

class DiemDanhRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ngay' => ['required', 'date'],
            'co_so_id' => ['required', 'exists:co_sos,id'],

            'diem_danh' => ['required', 'array', 'min:1'],
            'diem_danh.*.hoc_vien_id' => ['required', 'exists:hoc_viens,id'],
            'diem_danh.*.trang_thai' => ['required', Rule::enum(TrangThaiDiemDanh::class)],
            'diem_danh.*.ghi_chu' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'ngay.required' => 'Ngày điểm danh không được để trống.',
            'ngay.date' => 'Ngày điểm danh không đúng định dạng ngày tháng.',
            'co_so_id.required' => 'Vui lòng chọn cơ sở.',
            'co_so_id.exists' => 'Cơ sở được chọn không tồn tại trên hệ thống.',
            'diem_danh.required' => 'Danh sách điểm danh không được để trống.',
            'diem_danh.array' => 'Danh sách điểm danh phải là một mảng.',
            'diem_danh.min' => 'Danh sách điểm danh phải có ít nhất một học viên.',
            'diem_danh.*.hoc_vien_id.required' => 'Học viên không được để trống.',
            'diem_danh.*.hoc_vien_id.exists' => 'Học viên không tồn tại trên hệ thống.',
            'diem_danh.*.trang_thai.required' => 'Trạng thái điểm danh không được để trống.',
            'diem_danh.*.trang_thai.Illuminate\Validation\Rules\Enum' => 'Trạng thái điểm danh không hợp lệ.',
            'diem_danh.*.ghi_chu.string' => 'Ghi chú phải là chuỗi ký tự.',
            'diem_danh.*.ghi_chu.max' => 'Ghi chú không được vượt quá 255 ký tự.',
        ];
    }
}