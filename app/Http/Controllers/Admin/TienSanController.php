<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TienSan\TienSanRequest;
use App\Models\CoSo;
use App\Models\TienSan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TienSanController extends Controller
{
    public function index(Request $request)
    {
        $thangHienTai = now()->startOfMonth();
        $thangInput = $request->input('thang') ?: $thangHienTai->format('Y-m');
        $thang = Carbon::createFromFormat('Y-m', $thangInput)->startOfMonth();

        // Không cho xem tháng trong tương lai — kẹp về tháng hiện tại nếu bị truyền quá tay (sửa URL, F5 qua tháng mới...)
        if ($thang->gt($thangHienTai)) {
            $thang = $thangHienTai->copy();
        }

        $query = TienSan::with('coSo')
            ->whereBetween('ngay', [$thang->toDateString(), $thang->copy()->endOfMonth()->toDateString()])
            ->orderByDesc('ngay');

        if ($request->filled('co_so_id')) {
            $query->where('co_so_id', $request->co_so_id);
        }

        $tienSans = $query->paginate(10)->withQueryString();
        $coSos = CoSo::orderBy('ten')->get();

        // Chỉ liệt kê tháng hiện tại + các tháng trong quá khứ, không có tháng tương lai để chọn
        $danhSachThang = collect(range(0, 11))->map(function ($i) {
            $d = now()->subMonths($i)->startOfMonth();

            return [
                'value' => $d->format('Y-m'),
                'label' => 'Tháng '.$d->format('n/Y'),
            ];
        });

        $tongTienThang = TienSan::whereBetween('ngay', [$thang->toDateString(), $thang->copy()->endOfMonth()->toDateString()])
            ->when($request->filled('co_so_id'), fn ($q) => $q->where('co_so_id', $request->co_so_id))
            ->sum('so_tien');

        return view('tiensan.index', compact('tienSans', 'coSos', 'thang', 'danhSachThang', 'tongTienThang'));
    }

    public function store(TienSanRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('bill')) {
            $data['bill'] = $request->file('bill')->store('tien-san-bills', 'public');
        }

        TienSan::create($data);

        $thang = Carbon::parse($data['ngay'])->format('Y-m');

        return redirect()->route('tiensan.index', ['thang' => $thang])->with('success', 'Tạo bản ghi Tiền sân thành công');
    }

    public function update(TienSanRequest $request, TienSan $tiensan)
    {
        $data = $request->validated();

        if ($request->hasFile('bill')) {
            if ($tiensan->bill) {
                Storage::disk('public')->delete($tiensan->bill);
            }
            $data['bill'] = $request->file('bill')->store('tien-san-bills', 'public');
        }

        $tiensan->update($data);

        $thang = Carbon::parse($data['ngay'])->format('Y-m');

        return redirect()->route('tiensan.index', ['thang' => $thang])->with('success', 'Cập nhật bản ghi Tiền sân thành công');
    }

    public function destroy(Request $request, TienSan $tiensan)
    {
        $thang = $tiensan->ngay->format('Y-m');

        if ($tiensan->bill) {
            Storage::disk('public')->delete($tiensan->bill);
        }

        $tiensan->delete();

        return redirect()->route('tiensan.index', ['thang' => $thang])->with('success', 'Xoá bản ghi Tiền sân thành công');
    }
}