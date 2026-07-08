<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GiaoVien\GiaoVienRequest;
use App\Models\GiaoVien;

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
        $giaovien->delete();

        return redirect()->route('giaovien.index')->with('success', 'Xoá giáo viên thành công');
    }
}