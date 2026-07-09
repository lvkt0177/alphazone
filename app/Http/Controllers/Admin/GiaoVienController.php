<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GiaoVien\GiaoVienRequest;
use App\Models\GiaoVien;
use App\Enum\TrangThaiGiaoVien;
use Illuminate\Database\QueryException;

class GiaoVienController extends Controller
{
    public function index()
    {
        $giaoViens = GiaoVien::orderBy('id')->get();

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

        try {
            $giaovien->delete();
        } catch (QueryException $e) {
            return redirect()->route('giaovien.index')->with('error',
                'Không thể xoá: giáo viên này đang phụ trách ít nhất 1 Cơ sở. '
                .'Hãy đổi người phụ trách cho các Cơ sở đó trước.'
            );
        }

        return redirect()->route('giaovien.index')->with('success', 'Xoá giáo viên thành công');
    }

    /**
     * Case: GV nghỉ dạy → soft, không xoá dòng.
     * TODO: khi có hệ thống phân quyền (Hướng A), chỉ Chủ tịch được gọi action này.
     */
    public function toggleTrangThai(GiaoVien $giaovien)
    {
        $giaovien->trang_thai = $giaovien->trang_thai === TrangThaiGiaoVien::DANG_DAY
            ? TrangThaiGiaoVien::DA_NGHI
            : TrangThaiGiaoVien::DANG_DAY;
        $giaovien->save();

        return redirect()->route('giaovien.index')->with('success', 'Cập nhật trạng thái giáo viên thành công');
    }
}