<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CoSo\CoSoRequest;
use App\Models\CoSo;
use App\Models\GiaoVien;
use App\Enum\TrangThaiCoSo;
use App\Enum\TrangThaiGiaoVien;
use Illuminate\Database\QueryException;

class CoSoController extends Controller
{
    public function index()
    {
        $coSos = CoSo::with('giaoVien')
            ->withCount('hocViens')
            ->orderBy('id')->get();

        $giaoViens = GiaoVien::where('trang_thai', TrangThaiGiaoVien::DANG_DAY)
            ->orderBy('ho_ten')->get();

        return view('branches.index', compact('coSos', 'giaoViens'));
    }

    public function store(CoSoRequest $request)
    {
        CoSo::create($request->validated());

        return redirect()->route('coso.index')->with('success', 'Thêm cơ sở thành công');
    }

    public function update(CoSoRequest $request, CoSo $coso)
    {
        $coso->update($request->validated());

        return redirect()->route('coso.index')->with('success', 'Cập nhật cơ sở thành công');
    }
    
    public function destroy(CoSo $coso)
    {
        if ($coso->trang_thai === TrangThaiCoSo::INACTIVE) {
            return redirect()->route('coso.index')->with('error',
                'Không thể xoá: Cơ sở này đã từng ở trạng thái "Ngừng hoạt động" (đã từng vận hành thật). '
                .'Dữ liệu này cần được giữ lại để tra cứu lịch sử.'
            );
        }

        try {
            $coso->delete();
        } catch (QueryException $e) {
            return redirect()->route('coso.index')->with('error',
                'Không thể xoá: Cơ sở này đang có Học viên hoặc lịch sử Điểm danh liên kết. '
                .'Hãy chuyển Cơ sở sang trạng thái "Ngừng hoạt động" thay vì xoá.'
            );
        }

        return redirect()->route('coso.index')->with('success', 'Xoá cơ sở thành công');
    }
   
    public function toggleTrangThai(CoSo $coso)
    {
        $coso->trang_thai = $coso->trang_thai === TrangThaiCoSo::ACTIVE
            ? TrangThaiCoSo::INACTIVE
            : TrangThaiCoSo::ACTIVE;
        $coso->save();

        return redirect()->route('coso.index')->with('success', 'Cập nhật trạng thái cơ sở thành công');
    }
}