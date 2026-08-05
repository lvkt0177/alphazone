<?php

namespace App\Http\Requests\Admin\BieuMau;

use Illuminate\Foundation\Http\FormRequest;

class BieuMauMauTrongRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:30720'],
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'Vui lòng chọn file mẫu trống để tải lên.',
            'file.file' => 'File tải lên không hợp lệ.',
            'file.mimes' => 'Chỉ chấp nhận file định dạng PDF, DOC, DOCX, XLS, XLSX.',
            'file.max' => 'Dung lượng file không được vượt quá 30MB.',
        ];
    }
}
