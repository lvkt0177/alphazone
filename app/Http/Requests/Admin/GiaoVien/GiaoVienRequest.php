<?php

namespace App\Http\Requests\Admin\GiaoVien;

use Illuminate\Foundation\Http\FormRequest;
use App\Enum\ChucDanhGiaoVien;
use Illuminate\Validation\Rule;

class GiaoVienRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $giaoVienId = $this->route('giaovien')?->id;

        return [
            'ho_ten' => ['required', 'string', 'max:255'],
            'ma_nhan_vien' => [
                'required', 'string', 'max:50',
                Rule::unique('giao_viens', 'ma_nhan_vien')->ignore($giaoVienId),
            ],
            'cccd' => [
                'nullable', 'string', 'regex:/^[0-9]{12}$/',
                Rule::unique('giao_viens', 'cccd')->ignore($giaoVienId),
            ],
            'ngay_sinh' => ['nullable', 'date'],
            'sdt' => ['nullable', 'string', 'max:15', 'regex:/^[0-9]+$/'],
            'chuc_danh' => ['required', Rule::enum(ChucDanhGiaoVien::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'ho_ten.required' => 'Họ tên không được để trống.',
            'ho_ten.string' => 'Họ tên phải là chuỗi ký tự.',
            'ho_ten.max' => 'Họ tên không được vượt quá 255 ký tự.',
            'ma_nhan_vien.required' => 'Mã nhân viên không được để trống.',
            'ma_nhan_vien.max' => 'Mã nhân viên không được vượt quá 50 ký tự.',
            'ma_nhan_vien.unique' => 'Mã nhân viên này đã tồn tại.',
            'cccd.regex' => 'CCCD phải gồm đúng 12 chữ số.',
            'cccd.unique' => 'Số CCCD này đã tồn tại.',
            'ngay_sinh.date' => 'Ngày sinh không đúng định dạng ngày tháng.',
            'sdt.string' => 'Số điện thoại phải là chuỗi ký tự.',
            'sdt.max' => 'Số điện thoại không được vượt quá 15 ký tự.',
            'sdt.regex' => 'Số điện thoại không hợp lệ.',
            'chuc_danh.required' => 'Chức danh không được để trống.',
            'chuc_danh.enum' => 'Chức danh không hợp lệ.',
        ];
    }
}