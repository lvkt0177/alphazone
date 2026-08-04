<?php

namespace App\Http\Requests\Admin\TienSan;

use Illuminate\Foundation\Http\FormRequest;

class TienSanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'co_so_id' => ['required', 'exists:co_sos,id'],
            'ngay' => ['required', 'date', 'before_or_equal:today'],
            'so_tien' => ['required', 'integer', 'min:0'],
            'ghi_chu' => ['nullable', 'string', 'max:255'],
            'bill' => ['nullable', 'image', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'co_so_id.required' => 'Vui lòng chọn Cơ sở.',
            'co_so_id.exists' => 'Cơ sở được chọn không tồn tại.',
            'ngay.required' => 'Vui lòng chọn ngày.',
            'ngay.date' => 'Ngày không đúng định dạng.',
            'ngay.before_or_equal' => 'Không được chọn ngày trong tương lai.',
            'so_tien.required' => 'Số tiền không được để trống.',
            'so_tien.integer' => 'Số tiền phải là số nguyên.',
            'so_tien.min' => 'Số tiền không được nhỏ hơn 0.',
            'bill.image' => 'Bill phải là định dạng hình ảnh.',
            'bill.max' => 'Dung lượng ảnh Bill không được vượt quá 5MB.',
        ];
    }
}