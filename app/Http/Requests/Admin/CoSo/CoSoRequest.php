<?php

namespace App\Http\Requests\Admin\CoSo;

use Illuminate\Foundation\Http\FormRequest;

class CoSoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ten'          => ['required', 'string', 'max:255'],
            'giao_vien_id' => ['required', 'exists:giao_viens,id'],
        ];
    }
}