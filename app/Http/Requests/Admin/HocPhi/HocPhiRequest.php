<?php

namespace App\Http\Requests\Admin\HocPhi;

use Illuminate\Foundation\Http\FormRequest;

class HocPhiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hoc_vien_id' => ['required', 'exists:hoc_viens,id'],
            'thang' => ['required', 'date'],
            'gioi_thieu_ban' => ['nullable', 'boolean'],
            'hoc_phi' => ['required_if:gioi_thieu_ban,0', 'nullable', 'integer', 'min:0'],
            'dong_phuc' => ['nullable', 'integer', 'min:0'],
            'ngay_dong' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'hoc_vien_id.required' => 'Vui lòng chọn học viên.',
            'hoc_vien_id.exists' => 'Học viên được chọn không tồn tại trên hệ thống.',
            'thang.required' => 'Tháng đóng học phí không được để trống.',
            'thang.date' => 'Tháng đóng học phí không đúng định dạng ngày tháng.',
            'hoc_phi.required' => 'Học phí không được để trống.',
            'hoc_phi.integer' => 'Học phí phải là một số nguyên.',
            'hoc_phi.min' => 'Học phí không được nhỏ hơn 0.',
            'dong_phuc.integer' => 'Tiền đồng phục phải là một số nguyên.',
            'dong_phuc.min' => 'Tiền đồng phục không được nhỏ hơn 0.',
            'ngay_dong.required' => 'Ngày đóng không được để trống.',
            'ngay_dong.date' => 'Ngày đóng không đúng định dạng ngày tháng.',
            'hoc_phi.required_if' => 'Học phí không được để trống (trừ khi bật Giới thiệu bạn).',
        ];
    }
}
