<?php

namespace App\Http\Requests\Admin\ChamCong;

use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Foundation\Http\FormRequest;

class ChamCongHangLoatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ngay' => ['required', 'date', 'before_or_equal:today'],
            'rows' => ['required', 'array', 'min:1'],
            'rows.*.loai' => ['required', 'in:thay,ctv'],
            'rows.*.giao_vien_id' => ['required', 'integer', 'exists:giao_viens,id'],
            'rows.*.co_di_lam' => ['nullable', 'boolean'],
            'rows.*.so_gio' => ['nullable', 'numeric', 'min:0', 'max:24'],
            'rows.*.ho_tro_xang_xe' => ['nullable', 'integer', 'min:0', 'max:999999999'],
            'rows.*.ghi_chu' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'ngay.required' => 'Thiếu ngày chấm công.',
            'ngay.before_or_equal' => 'Không được chấm công cho ngày trong tương lai.',
            'rows.required' => 'Danh sách chấm công đang trống, chưa có gì để lưu.',
            'rows.min' => 'Danh sách chấm công đang trống, chưa có gì để lưu.',
            'rows.*.loai.required' => 'Thiếu loại chấm công.',
            'rows.*.giao_vien_id.required' => 'Thiếu người được chấm công.',
            'rows.*.giao_vien_id.exists' => 'Giáo viên không hợp lệ.',
            'rows.*.so_gio.max' => 'Số giờ không được vượt quá 24.',
            'rows.*.ho_tro_xang_xe.min' => 'Tiền hỗ trợ xăng xe không được âm.',
            'rows.*.ghi_chu.max' => 'Ghi chú không được vượt quá 255 ký tự.',
        ];
    }

    public function withValidator(ValidatorContract $validator): void
    {
        $validator->after(function (ValidatorContract $validator) {
            foreach ($this->input('rows', []) as $i => $row) {
                if (($row['loai'] ?? null) === 'thay' && ($row['co_di_lam'] ?? null) === null) {
                    $validator->errors()->add("rows.$i.co_di_lam", 'Vui lòng chọn trạng thái Có mặt/Không.');
                }

                if (($row['loai'] ?? null) === 'ctv' && ($row['so_gio'] ?? null) === null) {
                    $validator->errors()->add("rows.$i.so_gio", 'Vui lòng nhập số giờ (cho phép nhập 0).');
                }
            }
        });
    }
}
