<?php

namespace App\Http\Requests\Admin\GiaoAn;

use App\Enum\CapHocGiaoAn;
use App\Enum\ChuDeGiaoAn;
use App\Enum\LoaiGameGiaoAn;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class GiaoAnRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cap_hoc' => ['required', Rule::enum(CapHocGiaoAn::class)],
            'loai_game' => ['required', Rule::enum(LoaiGameGiaoAn::class)],
            'chu_de' => ['nullable', Rule::enum(ChuDeGiaoAn::class)],
            'ten_tro_choi' => ['required', 'string', 'max:255'],
            'cach_choi' => ['nullable', 'string', 'max:5000'],
            'luat_choi' => ['nullable', 'string', 'max:5000'],
            'so_do' => ['nullable', 'json'],
            'video' => ['nullable', 'file', 'mimetypes:video/mp4,video/quicktime,video/x-msvideo', 'max:51200'],
        ];
    }

    public function messages(): array
    {
        return [
            'cap_hoc.required' => 'Vui lòng chọn Cấp học.',
            'loai_game.required' => 'Vui lòng chọn Loại game.',
            'ten_tro_choi.required' => 'Tên trò chơi không được để trống.',
            'ten_tro_choi.max' => 'Tên trò chơi không được vượt quá 255 ký tự.',
            'video.mimetypes' => 'Video phải là định dạng mp4, mov hoặc avi.',
            'video.max' => 'Video không được vượt quá 50MB.',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $capHoc = CapHocGiaoAn::tryFrom((int) $this->input('cap_hoc'));
            $loaiGame = LoaiGameGiaoAn::tryFrom((int) $this->input('loai_game'));
            $chuDe = $this->filled('chu_de') ? ChuDeGiaoAn::tryFrom((int) $this->input('chu_de')) : null;

            if ($capHoc && $loaiGame && ! in_array($loaiGame, $capHoc->danhSachLoaiGame(), true)) {
                $validator->errors()->add('loai_game', 'Loại game không hợp lệ với Cấp học đã chọn.');
            }

            if ($capHoc) {
                if ($capHoc->coChuDe() && ! $chuDe) {
                    $validator->errors()->add('chu_de', 'Vui lòng chọn Chủ đề.');
                }

                if (! $capHoc->coChuDe() && $chuDe) {
                    $validator->errors()->add('chu_de', 'Mầm non không có Chủ đề.');
                }
            }
        });
    }
}
