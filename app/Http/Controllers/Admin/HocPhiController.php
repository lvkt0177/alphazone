<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HocPhi\HocPhiRequest;
use App\Models\HocPhi;
use App\Models\HocVien;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HocPhiController extends Controller
{
    public function index(Request $request)
    {
        $thangInput = $request->input('thang') ?: now()->format('Y-m');
        $thang = Carbon::createFromFormat('Y-m', $thangInput)->startOfMonth();

        $query = HocVien::with([
            'coSos',
            'hocPhis' => fn ($q) => $q->where('thang', $thang->toDateString()),
        ]);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(fn ($sub) => $sub->where('ma_so', 'like', "%{$q}%")
                ->orWhere('ho_ten', 'like', "%{$q}%"));
        }

        if ($request->trang_thai_dong === 'da_dong') {
            $query->whereHas('hocPhis', fn ($sub) => $sub->where('thang', $thang->toDateString()));
        } elseif ($request->trang_thai_dong === 'chua_dong') {
            $query->whereDoesntHave('hocPhis', fn ($sub) => $sub->where('thang', $thang->toDateString()));
        }

        $hocViens = $query->orderBy('ho_ten')->paginate(10)->withQueryString();

        $danhSachThang = collect(range(0, 11))->map(function ($i) {
            $d = now()->subMonths($i)->startOfMonth();

            return ['value' => $d->format('Y-m'), 'label' => 'Tháng '.$d->format('n/Y')];
        });

        $countDaDong = HocVien::whereHas('hocPhis', fn ($sub) => $sub->where('thang', $thang->toDateString()))->count();
        $countChuaDong = HocVien::whereDoesntHave('hocPhis', fn ($sub) => $sub->where('thang', $thang->toDateString()))->count();

        return view('tuition.index', compact('hocViens', 'thang', 'danhSachThang', 'countDaDong', 'countChuaDong'));
    }

    public function store(HocPhiRequest $request)
    {
        $data = $request->validated();
        $thang = Carbon::parse($data['thang'])->startOfMonth()->toDateString();

        HocPhi::updateOrCreate(
            ['hoc_vien_id' => $data['hoc_vien_id'], 'thang' => $thang],
            [
                'hoc_phi' => $data['hoc_phi'],
                'dong_phuc' => $data['dong_phuc'] ?? null,
                'ngay_dong' => $data['ngay_dong'],
            ]
        );

        return redirect()
            ->route('hocphi.index', ['thang' => Carbon::parse($thang)->format('Y-m')])
            ->with('success', 'Lưu học phí thành công');
    }

    public function destroy(Request $request)
    {
        $data = $request->validate([
            'hoc_vien_id' => 'required|integer|exists:hoc_viens,id',
            'thang' => 'required|date',
        ]);

        $thang = Carbon::parse($data['thang'])->startOfMonth()->toDateString();

        HocPhi::where('hoc_vien_id', $data['hoc_vien_id'])
            ->where('thang', $thang)
            ->delete();

        return redirect()
            ->route('hocphi.index', ['thang' => Carbon::parse($thang)->format('Y-m')])
            ->with('success', 'Đã xoá bản ghi học phí, học viên trở về trạng thái Chưa đóng');
    }
}