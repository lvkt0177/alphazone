<?php

namespace App\Http\Requests\Admin\HocPhi;

use App\Enum\MucDongPhuc;
use App\Enum\SizeDongPhuc;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HocPhiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'gioi_thieu_ban' => $this->boolean('gioi_thieu_ban') ? '1' : '0',
        ]);
    }

    public function rules(): array
    {
        return [
            'hoc_vien_id' => ['required', 'exists:hoc_viens,id'],
            'thang' => ['required', 'date'],
            'gioi_thieu_ban' => ['required', 'boolean'],
            'nguoi_gioi_thieu_id' => ['nullable', 'required_if:gioi_thieu_ban,1', 'exists:hoc_viens,id', 'different:hoc_vien_id'],
            'hoc_phi' => ['required_if:gioi_thieu_ban,0', 'nullable', 'integer', 'min:0'],
            'dong_phuc' => ['nullable', Rule::enum(MucDongPhuc::class), 'required_with:dong_phuc_size'],
            'dong_phuc_size' => ['nullable', Rule::enum(SizeDongPhuc::class), 'required_with:dong_phuc'],
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
            'dong_phuc.enum' => 'Mức giá đồng phục không hợp lệ.',
            'dong_phuc.required_with' => 'Vui lòng chọn Mức giá đồng phục.',
            'dong_phuc_size.enum' => 'Size đồng phục không hợp lệ.',
            'dong_phuc_size.required_with' => 'Vui lòng chọn Size đồng phục.',
            'ngay_dong.required' => 'Ngày đóng không đúng định dạng ngày tháng.',
            'hoc_phi.required_if' => 'Học phí không được để trống (trừ khi bật Giới thiệu bạn).',
            'nguoi_gioi_thieu_id.required_if' => 'Vui lòng chọn học viên đã giới thiệu.',
            'nguoi_gioi_thieu_id.different' => 'Học viên không thể tự giới thiệu chính mình.',
        ];
    }
}