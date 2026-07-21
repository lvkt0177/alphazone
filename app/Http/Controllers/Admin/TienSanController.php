<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TienSan\TienSanRequest;
use App\Models\CoSo;
use App\Models\TienSan;
use Illuminate\Http\Request;

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
        TienSan::create($request->validated());

        return redirect()->route('tiensan.index')->with('success', 'Tạo bản ghi Tiền sân thành công');
    }

    public function update(TienSanRequest $request, TienSan $tiensan)
    {
        $tiensan->update($request->validated());

        return redirect()->route('tiensan.index')->with('success', 'Cập nhật bản ghi Tiền sân thành công');
    }

    public function destroy(TienSan $tiensan)
    {
        $tiensan->delete();

        return redirect()->route('tiensan.index')->with('success', 'Xoá bản ghi Tiền sân thành công');
    }
}
