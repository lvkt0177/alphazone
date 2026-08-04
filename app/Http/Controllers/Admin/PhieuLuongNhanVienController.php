<?php

namespace App\Http\Controllers\Admin;

use App\Enum\ChucDanhGiaoVien;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PhieuLuong\PhieuLuongNhanVienRequest;
use App\Models\CaiDatLuongThay;
use App\Models\ChamCongGiaoVien;
use App\Models\GiaoVien;
use App\Models\PhieuLuongNhanVien;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PhieuLuongNhanVienController extends Controller
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

        $phieus = PhieuLuongNhanVien::where('thang', $thang->toDateString())
            ->orderBy('ho_ten_snapshot')
            ->get();

        return view('phieuluong.nhanvien.index', compact('phieus', 'thang'));
    }

    public function create(Request $request)
    {
        $thang = $this->thangHopLe($request->input('thang'));

        $daCoPhieu = PhieuLuongNhanVien::where('thang', $thang->toDateString())->pluck('giao_vien_id');

        $giaoViens = GiaoVien::where('chuc_danh', ChucDanhGiaoVien::THAY_PHU_TRACH->value)
            ->whereNotIn('id', $daCoPhieu)
            ->orderBy('ho_ten')
            ->get();

        $caiDat = CaiDatLuongThay::hienTai();
        $dauThang = $thang->copy()->startOfMonth()->toDateString();
        $cuoiThang = $thang->copy()->endOfMonth()->toDateString();

        $duLieuGiaoVien = $giaoViens->mapWithKeys(function ($gv) use ($dauThang, $cuoiThang) {
            $soCo = ChamCongGiaoVien::where('giao_vien_id', $gv->id)
                ->whereBetween('ngay', [$dauThang, $cuoiThang])
                ->where('co_di_lam', true)->count();
            $soKhong = ChamCongGiaoVien::where('giao_vien_id', $gv->id)
                ->whereBetween('ngay', [$dauThang, $cuoiThang])
                ->where('co_di_lam', false)->count();

            return [$gv->id => [
                'ho_ten' => $gv->ho_ten,
                'ma_nhan_vien' => $gv->ma_nhan_vien,
                'luong_co_ban' => $gv->luong_co_ban,
                'so_ngay_co_luong' => $soCo,
                'so_ngay_khong_luong' => $soKhong,
            ]];
        });

        return view('phieuluong.nhanvien.create', compact('giaoViens', 'thang', 'caiDat', 'duLieuGiaoVien'));
    }

    private function tinhToan(array $d, int $luongCoBan, int $tongKhauTru, int $truNgayThieu): array
    {
        $troCap = (int) ($d['tro_cap'] ?? 0);
        $nangSuat = (int) ($d['nang_suat'] ?? 0);
        $thuongKhac = (int) ($d['thuong_khac'] ?? 0);
        $congTacPhi = (int) ($d['cong_tac_phi'] ?? 0);
        $tamUng = (int) ($d['tam_ung'] ?? 0);
        // Thuế TNCN nhập tay hoàn toàn — không còn gợi ý tự động, admin tự quyết định
        $thueTncn = (int) ($d['thue_tncn'] ?? 0);

        $tongThuNhap = $luongCoBan + $troCap + $nangSuat + $thuongKhac - $truNgayThieu;

        $thuNhapChiuThue = $tongThuNhap - $tongKhauTru + $tamUng + $congTacPhi;

        $luongThucNhan = $thuNhapChiuThue - $thueTncn;

        return [
            'tong_thu_nhap' => $tongThuNhap,
            'tong_khau_tru' => $tongKhauTru,
            'thu_nhap_chiu_thue' => $thuNhapChiuThue,
            'thue_tncn' => $thueTncn,
            'luong_thuc_nhan' => $luongThucNhan,
        ];
    }

    public function store(PhieuLuongNhanVienRequest $request)
    {
        $data = $request->validated();
        $giaoVien = GiaoVien::findOrFail($data['giao_vien_id']);
        $thang = Carbon::createFromFormat('Y-m', $data['thang'])->startOfMonth();

        $luongCoBan = $giaoVien->luong_co_ban ?? 0;
        $bhxh = (int) round($luongCoBan * 0.08);
        $bhyt = (int) round($luongCoBan * 0.015);
        $bhtn = (int) round($luongCoBan * 0.01);
        $tongKhauTru = $bhxh + $bhyt + $bhtn;

        $dauThang = $thang->copy()->startOfMonth()->toDateString();
        $cuoiThang = $thang->copy()->endOfMonth()->toDateString();
        $soNgayCoLuong = ChamCongGiaoVien::where('giao_vien_id', $giaoVien->id)
            ->whereBetween('ngay', [$dauThang, $cuoiThang])->where('co_di_lam', true)->count();
        $soNgayKhongLuong = ChamCongGiaoVien::where('giao_vien_id', $giaoVien->id)
            ->whereBetween('ngay', [$dauThang, $cuoiThang])->where('co_di_lam', false)->count();

        $ngayCongChuan = (int) ($data['ngay_cong_chuan'] ?? 0);
        $tienTru1Ngay = (int) CaiDatLuongThay::hienTai()->tien_tru_1_ngay;
        $soNgayThieu = max(0, $ngayCongChuan - $soNgayCoLuong);
        $truNgayThieu = $soNgayThieu * $tienTru1Ngay;

        $tinh = $this->tinhToan($data, $luongCoBan, $tongKhauTru, $truNgayThieu);

        PhieuLuongNhanVien::create([
            'giao_vien_id' => $giaoVien->id,
            'thang' => $thang->toDateString(),
            'ngay_chot' => $data['ngay_chot'] ?? null,
            'ho_ten_snapshot' => $giaoVien->ho_ten,
            'ma_nhan_vien_snapshot' => $giaoVien->ma_nhan_vien,
            'luong_co_ban' => $luongCoBan,
            'ngay_cong_chuan' => $data['ngay_cong_chuan'] ?? null,
            'so_ngay_co_luong' => $soNgayCoLuong,
            'so_ngay_khong_luong' => $soNgayKhongLuong,
            'tro_cap' => $data['tro_cap'] ?? null,
            'nang_suat' => $data['nang_suat'] ?? null,
            'thuong_khac' => $data['thuong_khac'] ?? null,
            'cong_tac_phi' => $data['cong_tac_phi'] ?? null,
            'tam_ung' => $data['tam_ung'] ?? null,
            'giam_tru_gia_canh' => $data['giam_tru_gia_canh'] ?? null,
            'bhxh' => $bhxh,
            'bhyt' => $bhyt,
            'bhtn' => $bhtn,
            ...$tinh,
            'updated_by_user_id' => auth()->id(),
        ]);

        return redirect()->route('phieuluongnhanvien.index', ['thang' => $data['thang']])
            ->with('success', 'Tạo phiếu lương thành công');
    }

    public function edit(PhieuLuongNhanVien $phieu)
    {
        $thang = Carbon::parse($phieu->thang);
        $caiDat = CaiDatLuongThay::hienTai();

        return view('phieuluong.nhanvien.edit', compact('phieu', 'thang', 'caiDat'));
    }

    public function update(PhieuLuongNhanVienRequest $request, PhieuLuongNhanVien $phieu)
    {
        $data = $request->validated();

        $luongCoBan = $phieu->luong_co_ban;
        $bhxh = (int) round($luongCoBan * 0.08);
        $bhyt = (int) round($luongCoBan * 0.015);
        $bhtn = (int) round($luongCoBan * 0.01);
        $tongKhauTru = $bhxh + $bhyt + $bhtn;

        $ngayCongChuan = (int) ($data['ngay_cong_chuan'] ?? 0);
        $tienTru1Ngay = (int) CaiDatLuongThay::hienTai()->tien_tru_1_ngay;
        $soNgayThieu = max(0, $ngayCongChuan - $phieu->so_ngay_co_luong);
        $truNgayThieu = $soNgayThieu * $tienTru1Ngay;

        $tinh = $this->tinhToan($data, $luongCoBan, $tongKhauTru, $truNgayThieu);

        $phieu->update([
            'ngay_chot' => $data['ngay_chot'] ?? null,
            'ngay_cong_chuan' => $data['ngay_cong_chuan'] ?? null,
            'tro_cap' => $data['tro_cap'] ?? null,
            'nang_suat' => $data['nang_suat'] ?? null,
            'thuong_khac' => $data['thuong_khac'] ?? null,
            'cong_tac_phi' => $data['cong_tac_phi'] ?? null,
            'tam_ung' => $data['tam_ung'] ?? null,
            'giam_tru_gia_canh' => $data['giam_tru_gia_canh'] ?? null,
            'bhxh' => $bhxh,
            'bhyt' => $bhyt,
            'bhtn' => $bhtn,
            ...$tinh,
            'updated_by_user_id' => auth()->id(),
        ]);

        return redirect()->route('phieuluongnhanvien.index', ['thang' => $phieu->thang->format('Y-m')])
            ->with('success', 'Cập nhật phiếu lương thành công');
    }

    public function destroy(PhieuLuongNhanVien $phieu)
    {
        $thang = $phieu->thang->format('Y-m');
        $phieu->delete();

        return redirect()->route('phieuluongnhanvien.index', ['thang' => $thang])
            ->with('success', 'Xoá phiếu lương thành công');
    }

    public function xuatExcel(Request $request)
    {
        $thang = $this->thangHopLe($request->input('thang'));

        $phieus = PhieuLuongNhanVien::where('thang', $thang->toDateString())
            ->orderBy('ho_ten_snapshot')
            ->get();

        $path = \App\Support\Exports\XuatPhieuLuongNhanVien::taoFile($phieus, $thang);

        return response()->download($path, 'Bang-luong-thang-'.$thang->format('m-Y').'.xlsx')->deleteFileAfterSend(true);
    }
}