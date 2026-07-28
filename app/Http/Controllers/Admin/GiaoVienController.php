<?php

namespace App\Http\Controllers\Admin;

use App\Enum\RoleUser;
use App\Enum\TrangThaiCoSo;
use App\Enum\TrangThaiGiaoVien;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GiaoVien\GiaoVienRequest;
use App\Models\ChucNang;
use App\Models\GiaoVien;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class GiaoVienController extends Controller
{
    public function index()
    {
        $giaoViens = GiaoVien::with(['coSos', 'user.permissions'])->orderBy('id')->get();

        return view('teachers.index', compact('giaoViens'));
    }

    public function store(GiaoVienRequest $request)
    {
        GiaoVien::create($request->validated());

        return redirect()->route('giaovien.index')->with('success', 'Thêm giáo viên thành công');
    }

    public function update(GiaoVienRequest $request, GiaoVien $giaovien)
    {
        $giaovien->update($request->validated());

        return redirect()->route('giaovien.index')->with('success', 'Cập nhật giáo viên thành công');
    }

    public function destroy(GiaoVien $giaovien)
    {
        if ($giaovien->trang_thai === TrangThaiGiaoVien::DA_NGHI) {
            return redirect()->route('giaovien.index')->with('error',
                'Không thể xoá: giáo viên này đã từng ở trạng thái "Đã nghỉ" (đã từng vận hành thật). '
                .'Theo quy định, giáo viên đã nghỉ dạy chỉ được lưu lại (soft delete), không được xoá khỏi hệ thống.'
            );
        }

        $activeCoSo = $giaovien->coSos()->where('trang_thai', TrangThaiCoSo::ACTIVE)->first();
        if ($activeCoSo) {
            return redirect()->route('giaovien.index')->with('error', "Không thể xoá: giáo viên này đang phụ trách cơ sở \"{$activeCoSo->ten}\" đang hoạt động.");
        }

        try {
            $giaovien->delete();
        } catch (QueryException $e) {
            $allCoSoNames = $giaovien->coSos()->pluck('ten')->implode(', ');

            return redirect()->route('giaovien.index')->with('error',
                "Không thể xoá: giáo viên này vẫn đang đứng tên phụ trách các Cơ sở đã dừng hoạt động ({$allCoSoNames}). "
                .'Hãy đổi người phụ trách cho các Cơ sở đó trước.'
            );
        }

        return redirect()->route('giaovien.index')->with('success', 'Xoá giáo viên thành công');
    }

    public function toggleTrangThai(GiaoVien $giaovien)
    {
        $giaovien->trang_thai = $giaovien->trang_thai === TrangThaiGiaoVien::DANG_DAY
            ? TrangThaiGiaoVien::DA_NGHI
            : TrangThaiGiaoVien::DANG_DAY;
        $giaovien->save();

        return redirect()->route('giaovien.index')->with('success', 'Cập nhật trạng thái giáo viên thành công');
    }

    public function capTaiKhoan(GiaoVien $giaovien)
    {
        if ($giaovien->user) {
            return redirect()->route('giaovien.index')->with('error', 'Giáo viên này đã có tài khoản.');
        }

        if (empty($giaovien->sdt)) {
            return redirect()->route('giaovien.index')->with('error',
                'Giáo viên chưa có số điện thoại. Vui lòng cập nhật số điện thoại trước khi cấp tài khoản.'
            );
        }

        $username = generate_username_from_name($giaovien->ho_ten);

        User::create([
            'name' => $username,
            'ho_ten' => $giaovien->ho_ten,
            'password' => $giaovien->sdt,
            'role' => RoleUser::GIAO_VIEN,
            'giao_vien_id' => $giaovien->id,
        ]);

        return redirect()->route('giaovien.index')->with('success',
            "Cấp tài khoản thành công. Tài khoản đăng nhập: {$username} — Mật khẩu: {$giaovien->sdt}"
        );
    }

    public function luuQuyen(Request $request, GiaoVien $giaovien)
    {
        if (! $giaovien->user) {
            return redirect()->route('giaovien.index')->with('error', 'Giáo viên này chưa có tài khoản để cấp quyền.');
        }

        $quyenInput = $request->input('quyen', []);

        foreach (ChucNang::all() as $chucNang) {
            $data = $quyenInput[$chucNang->id] ?? [];

            $giaovien->user->permissions()->updateOrCreate(
                ['chuc_nang_id' => $chucNang->id],
                [
                    'xem' => isset($data['xem']),
                    'them' => isset($data['them']),
                    'sua' => isset($data['sua']),
                    'xoa' => isset($data['xoa']),
                ]
            );
        }

        return redirect()->route('giaovien.index')->with('success', 'Cập nhật phân quyền thành công');
    }

    public function doiMatKhauTaiKhoan(GiaoVien $giaovien)
    {
        if (! $giaovien->user) {
            return redirect()->route('giaovien.index')->with('error', 'Giáo viên này chưa có tài khoản.');
        }

        if (empty($giaovien->sdt)) {
            return redirect()->route('giaovien.index')->with('error',
                'Giáo viên chưa có số điện thoại để đặt làm mật khẩu.'
            );
        }

        $giaovien->user->password = $giaovien->sdt;
        $giaovien->user->save();

        return redirect()->route('giaovien.index')->with('success',
            'Đổi mật khẩu thành công. Mật khẩu mới là số điện thoại của giáo viên.'
        );
    }
}