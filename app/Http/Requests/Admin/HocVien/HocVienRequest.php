<?php

namespace App\Http\Requests\Admin\HocVien;

use App\Enum\GioiTinh;
use App\Enum\TrangThaiHocVien;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HocVienRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $hocVienId = $this->route('hocvien')?->id;

        return [
            'ma_so' => ['required', 'string', 'max:50', Rule::unique('hoc_viens', 'ma_so')->ignore($hocVienId)],
            'ho_ten' => ['required', 'string', 'max:255'],
            'nickname' => ['nullable', 'string', 'max:100'],
            'ngay_sinh' => ['nullable', 'date'],
            'gioi_tinh' => ['required', Rule::enum(GioiTinh::class)],
            'sdt' => ['nullable', 'string', 'max:15', 'regex:/^[0-9]+$/'],
            'truong' => ['nullable', 'string', 'max:255'],
            'dia_chi' => ['nullable', 'string', 'max:255'],
            'ghi_chu' => ['nullable', 'string', 'max:2000'],
            'avatar' => ['nullable', 'image', 'max:5120'],
            'trang_thai' => ['required', Rule::enum(TrangThaiHocVien::class)],
            'co_so_ids' => ['required', 'array', 'min:1'],
            'co_so_ids.*' => ['exists:co_sos,id'],
            'tu_trai_nghiem_id' => ['nullable', 'exists:hoc_vien_trai_nghiems,id'],
            'chieu_cao' => ['nullable', 'numeric', 'min:0', 'max:250'],
            'can_nang' => ['nullable', 'numeric', 'min:0', 'max:200'],
        ];
    }

    public function messages(): array
    {
        return [
            'ma_so.required' => 'Mã số học viên không được để trống.',
            'ma_so.string' => 'Mã số học viên phải là chuỗi ký tự.',
            'ma_so.max' => 'Mã số học viên không được vượt quá 50 ký tự.',
            'ma_so.unique' => 'Mã số học viên đã tồn tại trên hệ thống.',
            'ho_ten.required' => 'Họ tên không được để trống.',
            'ho_ten.string' => 'Họ tên phải là chuỗi ký tự.',
            'ho_ten.max' => 'Họ tên không được vượt quá 255 ký tự.',
            'nickname.string' => 'Nickname phải là chuỗi ký tự.',
            'nickname.max' => 'Nickname không được vượt quá 100 ký tự.',
            'ngay_sinh.date' => 'Ngày sinh không đúng định dạng ngày tháng.',
            'gioi_tinh.required' => 'Vui lòng chọn giới tính.',
            'gioi_tinh.Illuminate\Validation\Rules\Enum' => 'Giới tính chọn không hợp lệ.',
            'sdt.string' => 'Số điện thoại phải là chuỗi ký tự.',
            'sdt.max' => 'Số điện thoại không được vượt quá 15 ký tự.',
            'sdt.regex' => 'Số điện thoại không hợp lệ.',
            'truong.string' => 'Tên trường phải là chuỗi ký tự.',
            'truong.max' => 'Tên trường không được vượt quá 255 ký tự.',
            'dia_chi.string' => 'Địa chỉ phải là chuỗi ký tự.',
            'dia_chi.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'avatar.image' => 'Ảnh đại diện phải là định dạng hình ảnh.',
            'avatar.max' => 'Dung lượng ảnh đại diện không được vượt quá 5MB.',
            'trang_thai.required' => 'Trạng thái không được để trống.',
            'trang_thai.Illuminate\Validation\Rules\Enum' => 'Trạng thái chọn không hợp lệ.',
            'co_so_ids.required' => 'Vui lòng chọn ít nhất một cơ sở.',
            'co_so_ids.array' => 'Danh sách cơ sở phải là một mảng.',
            'co_so_ids.min' => 'Vui lòng chọn ít nhất một cơ sở.',
            'co_so_ids.*.exists' => 'Cơ sở được chọn không tồn tại trên hệ thống.',
            'tu_trai_nghiem_id.exists' => 'Thông tin học viên trải nghiệm không tồn tại trên hệ thống.',
            'ghi_chu.string' => 'Ghi chú phải là chuỗi ký tự.',
            'ghi_chu.max' => 'Ghi chú không được vượt quá 2000 ký tự.',
            'chieu_cao.numeric' => 'Chiều cao phải là số.',
            'can_nang.numeric' => 'Cân nặng phải là số.',
        ];
    }
}
