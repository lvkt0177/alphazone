<?php

namespace App\Http\Requests\Admin\HoaDon;

use Illuminate\Foundation\Http\FormRequest;

class HoaDonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $dangSua = (bool) $this->route('hoadon');

        return [
            'ten' => ['required', 'string', 'max:255'],
            'ngay_tao' => ['required', 'date'],
            'file' => [$dangSua ? 'nullable' : 'required', 'file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:30720'],
        ];
    }

    public function messages(): array
    {
        return [
            'ten.required' => 'Tên hóa đơn không được để trống.',
            'ten.max' => 'Tên hóa đơn không được vượt quá 255 ký tự.',
            'file.required' => 'Vui lòng chọn file để tải lên.',
            'file.file' => 'File tải lên không hợp lệ.',
            'file.mimes' => 'Chỉ chấp nhận file định dạng PDF, DOC, DOCX, XLS, XLSX.',
            'file.max' => 'Dung lượng file không được vượt quá 30MB.',
            'ngay_tao.required' => 'Vui lòng chọn ngày tạo hóa đơn.',
            'ngay_tao.date' => 'Ngày tạo không đúng định dạng ngày tháng.',
        ];
    }
}
