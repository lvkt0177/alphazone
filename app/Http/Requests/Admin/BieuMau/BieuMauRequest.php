<?php

namespace App\Http\Requests\Admin\BieuMau;

use Illuminate\Foundation\Http\FormRequest;

class BieuMauRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $dangSua = (bool) $this->route('bieumau');

        return [
            'ten' => ['required', 'string', 'max:255'],
            'file' => [$dangSua ? 'nullable' : 'required', 'file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:30720'],
        ];
    }

    public function messages(): array
    {
        return [
            'ten.required' => 'Tên biểu mẫu không được để trống.',
            'ten.max' => 'Tên biểu mẫu không được vượt quá 255 ký tự.',
            'file.required' => 'Vui lòng chọn file để tải lên.',
            'file.file' => 'File tải lên không hợp lệ.',
            'file.mimes' => 'Chỉ chấp nhận file định dạng PDF, DOC, DOCX, XLS, XLSX.',
            'file.max' => 'Dung lượng file không được vượt quá 30MB.',
        ];
    }
}