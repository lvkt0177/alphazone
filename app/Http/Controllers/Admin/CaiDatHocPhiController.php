<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CaiDatHocPhi\CaiDatHocPhiRequest;
use App\Models\CaiDatHocPhi;

class CaiDatHocPhiController extends Controller
{
    public function index()
    {
        $caiDats = CaiDatHocPhi::orderBy('so_luong_co_so')->get();

        return view('caidat.hocphi.index', compact('caiDats'));
    }

    public function store(CaiDatHocPhiRequest $request)
    {
        CaiDatHocPhi::create($request->validated());

        return redirect()->route('caidathocphi.index')->with('success', 'Thêm cấu hình học phí thành công');
    }

    public function update(CaiDatHocPhiRequest $request, CaiDatHocPhi $caidathocphi)
    {
        $caidathocphi->update($request->validated());

        return redirect()->route('caidathocphi.index')->with('success', 'Cập nhật cấu hình học phí thành công');
    }

    public function destroy(CaiDatHocPhi $caidathocphi)
    {
        $caidathocphi->delete();

        return redirect()->route('caidathocphi.index')->with('success', 'Xoá cấu hình học phí thành công');
    }
}