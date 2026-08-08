<?php

namespace App\Http\Controllers\Admin;

use App\Enum\LoaiHoaDon;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HoaDon\HoaDonRequest;
use App\Models\HoaDon;
use App\Models\HocPhi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HoaDonController extends Controller
{
    public function menuDauVao()
    {
        $danhSachLoai = LoaiHoaDon::cases();

        return view('hoadon.dauvao.menu', compact('danhSachLoai'));
    }

    public function indexDauVao(int $loai)
    {
        $loaiHoaDon = LoaiHoaDon::tryFrom($loai);

        abort_if(! $loaiHoaDon, 404);

        $hoaDons = HoaDon::where('loai', $loaiHoaDon->value)
            ->orderByDesc('id')
            ->paginate(15);

        return view('hoadon.dauvao.index', compact('loaiHoaDon', 'hoaDons'));
    }

    public function storeDauVao(HoaDonRequest $request, int $loai)
    {
        $loaiHoaDon = LoaiHoaDon::tryFrom($loai);

        abort_if(! $loaiHoaDon, 404);

        $data = $request->validated();
        $file = $request->file('file');

        HoaDon::create([
            'loai' => $loaiHoaDon->value,
            'ten' => $data['ten'],
            'ngay_tao' => $data['ngay_tao'],
            'file_path' => $file->store('hoa-don', 'public'),
            'file_name_goc' => $file->getClientOriginalName(),
        ]);

        return redirect()->route('hoadon.dauvao.index', ['loai' => $loaiHoaDon->value])
            ->with('success', 'Tải lên hóa đơn thành công');
    }

    public function updateDauVao(HoaDonRequest $request, HoaDon $hoadon)
    {
        $data = $request->validated();
        $capNhat = ['ten' => $data['ten'], 'ngay_tao' => $data['ngay_tao']];

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($hoadon->file_path);
            $file = $request->file('file');
            $capNhat['file_path'] = $file->store('hoa-don', 'public');
            $capNhat['file_name_goc'] = $file->getClientOriginalName();
        }

        $hoadon->update($capNhat);

        return redirect()->route('hoadon.dauvao.index', ['loai' => $hoadon->loai->value])
            ->with('success', 'Cập nhật hóa đơn thành công');
    }

    public function downloadDauVao(HoaDon $hoadon)
    {
        abort_unless(Storage::disk('public')->exists($hoadon->file_path), 404);

        return Storage::disk('public')->download($hoadon->file_path, $hoadon->file_name_goc);
    }

    public function destroyDauVao(HoaDon $hoadon)
    {
        $loai = $hoadon->loai->value;

        Storage::disk('public')->delete($hoadon->file_path);
        $hoadon->delete();

        return redirect()->route('hoadon.dauvao.index', ['loai' => $loai])
            ->with('success', 'Xoá hóa đơn thành công');
    }

    public function dauRa(Request $request)
    {
        $thangInput = $request->input('thang') ?: now()->format('Y-m');
        $thang = Carbon::createFromFormat('Y-m', $thangInput)->startOfMonth();

        $tuNgay = $thang->copy()->startOfMonth()->toDateString();
        $denNgay = $thang->copy()->endOfMonth()->toDateString();

        $danhSachHocPhi = HocPhi::with('hocVien')
            ->whereHas('hocVien')
            ->whereBetween('ngay_dong', [$tuNgay, $denNgay])
            ->join('hoc_viens', 'hoc_viens.id', '=', 'hoc_phis.hoc_vien_id')
            ->orderBy('hoc_viens.ho_ten')
            ->orderBy('hoc_phis.ngay_dong')
            ->select('hoc_phis.*')
            ->get();

        $tongTien = $danhSachHocPhi->sum('hoc_phi');

        $danhSachThang = collect(range(-6, 11))->map(function ($i) {
            $d = now()->subMonths($i)->startOfMonth();

            return [
                'value' => $d->format('Y-m'),
                'label' => 'Tháng '.$d->format('n/Y').($i < 0 ? ' (sắp tới)' : ''),
            ];
        });

        return view('hoadon.daura.index', compact('thang', 'danhSachHocPhi', 'tongTien', 'danhSachThang'));
    }
}