<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TienSan\TienSanRequest;
use App\Models\CoSo;
use App\Models\TienSan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TienSanController extends Controller
{
    public function index(Request $request)
    {
        $query = TienSan::with('coSo')->orderByDesc('ngay');

        if ($request->filled('co_so_id')) {
            $query->where('co_so_id', $request->co_so_id);
        }

        $tienSans = $query->paginate(10)->withQueryString();
        $coSos = CoSo::orderBy('ten')->get();

        return view('tiensan.index', compact('tienSans', 'coSos'));
    }

    public function store(TienSanRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('bill')) {
            $data['bill'] = $request->file('bill')->store('tien-san-bills', 'public');
        }

        TienSan::create($data);

        return redirect()->route('tiensan.index')->with('success', 'Tạo bản ghi Tiền sân thành công');
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

        return redirect()->route('tiensan.index')->with('success', 'Cập nhật bản ghi Tiền sân thành công');
    }

    public function destroy(TienSan $tiensan)
    {
        if ($tiensan->bill) {
            Storage::disk('public')->delete($tiensan->bill);
        }

        $tiensan->delete();

        return redirect()->route('tiensan.index')->with('success', 'Xoá bản ghi Tiền sân thành công');
    }
}