<?php

namespace App\Http\Controllers\Admin;

use App\Enum\TrangThaiCoSo;
use App\Enum\TrangThaiGiaoVien;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GiaoVien\GiaoVienRequest;
use App\Models\GiaoVien;
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
}
