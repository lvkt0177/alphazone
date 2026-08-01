<?php

namespace App\Http\Requests\Admin\CaiDatTienLuong;

use App\Enum\ChucDanhGiaoVien;
use Illuminate\Foundation\Http\FormRequest;

class CaiDatTienLuongRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $giaoVien = $this->route('giaovien');
        $ten = $giaoVien?->chuc_danh === ChucDanhGiaoVien::THAY_PHU_TRACH ? 'luong_co_ban' : 'don_gia_gio';

        return [
            $ten => ['required', 'integer', 'min:0', 'max:999999999'],
        ];
    }

    public function messages(): array
    {
        return [
            'luong_co_ban.required' => 'Vui lòng nhập lương cơ bản.',
            'luong_co_ban.integer' => 'Lương cơ bản phải là số nguyên.',
            'luong_co_ban.min' => 'Lương cơ bản không được âm.',
            'don_gia_gio.required' => 'Vui lòng nhập đơn giá/giờ.',
            'don_gia_gio.integer' => 'Đơn giá/giờ phải là số nguyên.',
            'don_gia_gio.min' => 'Đơn giá/giờ không được âm.',
        ];
    }
}