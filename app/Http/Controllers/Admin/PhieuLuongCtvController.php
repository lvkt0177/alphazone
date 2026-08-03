<?php

namespace App\Http\Controllers\Admin;

use App\Enum\ChucDanhGiaoVien;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PhieuLuong\PhieuLuongCtvRequest;
use App\Models\ChamCongGiaoVien;
use App\Models\GiaoVien;
use App\Models\PhieuLuongCtv;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PhieuLuongCtvController extends Controller
{
    private function thangHopLe(?string $thang): Carbon
    {
        $thang = $thang ?: now()->format('Y-m');

        try {
            return Carbon::createFromFormat('Y-m', $thang)->startOfMonth();
        } catch (\Exception $e) {
            return now()->startOfMonth();
        }
    }

    public function index(Request $request)
    {
        $thang = $this->thangHopLe($request->input('thang'));

        $phieus = PhieuLuongCtv::where('thang', $thang->toDateString())
            ->orderBy('ho_ten_snapshot')
            ->get();

        return view('phieuluong.ctv.index', compact('phieus', 'thang'));
    }

    public function create(Request $request)
    {
        $thang = $this->thangHopLe($request->input('thang'));

        $daCoPhieu = PhieuLuongCtv::where('thang', $thang->toDateString())->pluck('giao_vien_id');

        $giaoViens = GiaoVien::where('chuc_danh', ChucDanhGiaoVien::TRO_GIANG->value)
            ->whereNotIn('id', $daCoPhieu)
            ->orderBy('ho_ten')
            ->get();

        $dauThang = $thang->copy()->startOfMonth()->toDateString();
        $cuoiThang = $thang->copy()->endOfMonth()->toDateString();

        $duLieuGiaoVien = $giaoViens->mapWithKeys(function ($gv) use ($dauThang, $cuoiThang) {
            $tongGio = ChamCongGiaoVien::where('giao_vien_id', $gv->id)
                ->whereBetween('ngay', [$dauThang, $cuoiThang])
                ->whereNotNull('so_gio')
                ->sum('so_gio');
            $troCap = (int) ChamCongGiaoVien::where('giao_vien_id', $gv->id)
                ->whereBetween('ngay', [$dauThang, $cuoiThang])
                ->sum('ho_tro_xang_xe');

            return [$gv->id => [
                'ho_ten' => $gv->ho_ten,
                'ma_nhan_vien' => $gv->ma_nhan_vien,
                'don_gia' => $gv->don_gia_gio,
                'tong_so_gio' => (float) $tongGio,
                'tro_cap' => $troCap,
            ]];
        });

        return view('phieuluong.ctv.create', compact('giaoViens', 'thang', 'duLieuGiaoVien'));
    }

    public function store(PhieuLuongCtvRequest $request)
    {
        $data = $request->validated();
        $giaoVien = GiaoVien::findOrFail($data['giao_vien_id']);
        $thang = Carbon::createFromFormat('Y-m', $data['thang'])->startOfMonth();

        $dauThang = $thang->copy()->startOfMonth()->toDateString();
        $cuoiThang = $thang->copy()->endOfMonth()->toDateString();

        $tongSoGio = (float) ChamCongGiaoVien::where('giao_vien_id', $giaoVien->id)
            ->whereBetween('ngay', [$dauThang, $cuoiThang])
            ->whereNotNull('so_gio')
            ->sum('so_gio');

        $donGia = $giaoVien->don_gia_gio ?? 0;
        $thanhTien = (int) round($tongSoGio * $donGia);
        $khauTru = (int) ($data['khau_tru'] ?? 0);
        $troCap = (int) ($data['tro_cap'] ?? 0);

        PhieuLuongCtv::create([
            'giao_vien_id' => $giaoVien->id,
            'thang' => $thang->toDateString(),
            'ho_ten_snapshot' => $giaoVien->ho_ten,
            'ma_nhan_vien_snapshot' => $giaoVien->ma_nhan_vien,
            'tong_so_gio' => $tongSoGio,
            'don_gia' => $donGia,
            'tro_cap' => $data['tro_cap'] ?? null,
            'thanh_tien' => $thanhTien,
            'khau_tru' => $data['khau_tru'] ?? null,
            'thuc_nhan' => $thanhTien + $troCap - $khauTru,
            'updated_by_user_id' => auth()->id(),
        ]);

        return redirect()->route('phieuluongctv.index', ['thang' => $data['thang']])
            ->with('success', 'Tạo phiếu lương thành công');
    }

    public function edit(PhieuLuongCtv $phieu)
    {
        $thang = Carbon::parse($phieu->thang);

        return view('phieuluong.ctv.edit', compact('phieu', 'thang'));
    }

    public function update(PhieuLuongCtvRequest $request, PhieuLuongCtv $phieu)
    {
        $data = $request->validated();
        $khauTru = (int) ($data['khau_tru'] ?? 0);
        $troCap = (int) ($data['tro_cap'] ?? 0);

        $phieu->update([
            'tro_cap' => $data['tro_cap'] ?? null,
            'khau_tru' => $data['khau_tru'] ?? null,
            'thuc_nhan' => $phieu->thanh_tien + $troCap - $khauTru,
            'updated_by_user_id' => auth()->id(),
        ]);

        return redirect()->route('phieuluongctv.index', ['thang' => $phieu->thang->format('Y-m')])
            ->with('success', 'Cập nhật phiếu lương thành công');
    }

    public function destroy(PhieuLuongCtv $phieu)
    {
        $thang = $phieu->thang->format('Y-m');
        $phieu->delete();

        return redirect()->route('phieuluongctv.index', ['thang' => $thang])
            ->with('success', 'Xoá phiếu lương thành công');
    }

    public function xuatExcel(Request $request)
    {
        $thang = $this->thangHopLe($request->input('thang'));

        $phieus = PhieuLuongCtv::where('thang', $thang->toDateString())
            ->orderBy('ho_ten_snapshot')
            ->get();

        $path = \App\Support\Exports\XuatPhieuLuongCtv::taoFile($phieus, $thang);

        return response()->download($path, 'Luong-CTV-thang-'.$thang->format('m-Y').'.xlsx')->deleteFileAfterSend(true);
    }
}