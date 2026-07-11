<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DiemDanh\DiemDanhRequest;
use App\Models\CoSo;
use App\Models\DiemDanh;
use App\Models\HocVien;
use App\Enum\TrangThaiCoSo;
use App\Enum\TrangThaiHocVien;
use Illuminate\Http\Request;

class DiemDanhController extends Controller
{
    public function index(Request $request)
    {
        $coSos = CoSo::where('trang_thai', TrangThaiCoSo::ACTIVE)->orderBy('ten')->get();

        $selectedCoSoId = $request->integer('co_so_id') ?: optional($coSos->first())->id;
        $selectedDate   = $request->input('ngay') ?: now()->toDateString();

        $hocViens = collect();
        $existing = collect();

        if ($selectedCoSoId) {
            // Chỉ điểm danh HV đang hoạt động thật (Khách hàng / Quay lại), bỏ qua Tạm nghỉ
            $hocViens = HocVien::whereHas('coSos', fn ($q) => $q->where('co_sos.id', $selectedCoSoId))
                ->whereIn('trang_thai', [TrangThaiHocVien::KHACH_HANG, TrangThaiHocVien::QUAY_LAI])
                ->orderBy('ho_ten')
                ->get();

            $existing = DiemDanh::where('co_so_id', $selectedCoSoId)
                ->where('ngay', $selectedDate)
                ->get()
                ->keyBy('hoc_vien_id');
        }

        return view('attendance.index', compact('coSos', 'selectedCoSoId', 'selectedDate', 'hocViens', 'existing'));
    }

    public function store(DiemDanhRequest $request)
    {
        $coSo = CoSo::findOrFail($request->co_so_id);

        foreach ($request->diem_danh as $row) {
            DiemDanh::updateOrCreate(
                [
                    'hoc_vien_id' => $row['hoc_vien_id'],
                    'co_so_id' => $request->co_so_id,
                    'ngay' => $request->ngay,
                ],
                [
                    'giao_vien_id' => $coSo->giao_vien_id,
                    'trang_thai' => $row['trang_thai'],
                    'ghi_chu' => $row['ghi_chu'] ?? null,
                ]
            );
        }

        return redirect()
            ->route('diemdanh.index', ['co_so_id' => $request->co_so_id, 'ngay' => $request->ngay])
            ->with('success', 'Lưu điểm danh thành công');
    }
}