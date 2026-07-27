<?php

namespace App\Http\Requests\Admin\CaiDatHocPhi;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CaiDatHocPhiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $dangSuaId = $this->route('caidathocphi')?->id;

        return [
            'so_luong_co_so' => [
                'required', 'integer', 'min:1',
                Rule::unique('cai_dat_hoc_phis', 'so_luong_co_so')->ignore($dangSuaId),
            ],
            'hoc_phi' => ['required', 'integer', 'min:0'],
            'tong_so_buoi' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'so_luong_co_so.required' => 'Vui lòng nhập số lượng Cơ sở.',
            'so_luong_co_so.integer' => 'Số lượng Cơ sở phải là số nguyên.',
            'so_luong_co_so.min' => 'Số lượng Cơ sở phải từ 1 trở lên.',
            'so_luong_co_so.unique' => 'Số lượng Cơ sở này đã được cấu hình rồi.',
            'hoc_phi.required' => 'Vui lòng nhập Học phí.',
            'hoc_phi.integer' => 'Học phí phải là số.',
            'hoc_phi.min' => 'Học phí không được âm.',
            'tong_so_buoi.required' => 'Vui lòng nhập Tổng số buổi.',
            'tong_so_buoi.integer' => 'Tổng số buổi phải là số nguyên.',
            'tong_so_buoi.min' => 'Tổng số buổi phải từ 1 trở lên.',
        ];
    }
}
