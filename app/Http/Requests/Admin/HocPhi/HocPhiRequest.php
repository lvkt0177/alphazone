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

            'dot' => ['required', 'array', 'min:1'],
            'dot.*.id' => ['nullable', 'integer', 'exists:hoc_phis,id'],
            'dot.*.hoc_phi' => ['required_if:gioi_thieu_ban,0', 'nullable', 'integer', 'min:0'],
            'dot.*.dong_phuc' => ['nullable', Rule::enum(MucDongPhuc::class)],
            'dot.*.dong_phuc_size' => ['nullable', Rule::enum(SizeDongPhuc::class)],
            'dot.*.ngay_dong' => ['required', 'date'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            foreach ($this->input('dot', []) as $i => $dot) {
                $coMuc = isset($dot['dong_phuc']) && $dot['dong_phuc'] !== '';
                $coSize = isset($dot['dong_phuc_size']) && $dot['dong_phuc_size'] !== '';

                if ($coMuc && ! $coSize) {
                    $validator->errors()->add("dot.$i.dong_phuc_size", 'Vui lòng chọn Size đồng phục.');
                }
                if ($coSize && ! $coMuc) {
                    $validator->errors()->add("dot.$i.dong_phuc", 'Vui lòng chọn Mức giá đồng phục.');
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'hoc_vien_id.required' => 'Vui lòng chọn học viên.',
            'hoc_vien_id.exists' => 'Học viên được chọn không tồn tại trên hệ thống.',
            'thang.required' => 'Tháng đóng học phí không được để trống.',
            'thang.date' => 'Tháng đóng học phí không đúng định dạng ngày tháng.',
            'nguoi_gioi_thieu_id.required_if' => 'Vui lòng chọn học viên đã giới thiệu.',
            'nguoi_gioi_thieu_id.different' => 'Học viên không thể tự giới thiệu chính mình.',
            'dot.required' => 'Cần ít nhất 1 đợt thanh toán.',
            'dot.*.hoc_phi.required_if' => 'Học phí không được để trống (trừ khi bật Giới thiệu bạn).',
            'dot.*.hoc_phi.integer' => 'Học phí phải là một số nguyên.',
            'dot.*.hoc_phi.min' => 'Học phí không được nhỏ hơn 0.',
            'dot.*.dong_phuc.enum' => 'Mức giá đồng phục không hợp lệ.',
            'dot.*.dong_phuc_size.enum' => 'Size đồng phục không hợp lệ.',
            'dot.*.ngay_dong.required' => 'Ngày đóng không được để trống.',
            'dot.*.ngay_dong.date' => 'Ngày đóng không đúng định dạng ngày tháng.',
        ];
    }
}