<?php

namespace App\Http\Controllers\Admin;

use App\Enum\LoaiBieuMau;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BieuMau\BieuMauRequest;
use App\Models\BieuMau;
use Illuminate\Support\Facades\Storage;

class BieuMauController extends Controller
{
    public function menu()
    {
        $danhSachLoai = LoaiBieuMau::cases();

        return view('bieumau.menu', compact('danhSachLoai'));
    }

    public function index(int $loai)
    {
        $loaiBieuMau = LoaiBieuMau::tryFrom($loai);

        abort_if(! $loaiBieuMau, 404);

        $bieuMaus = BieuMau::where('loai', $loaiBieuMau->value)
            ->orderByDesc('id')
            ->paginate(15);

        return view('bieumau.index', compact('loaiBieuMau', 'bieuMaus'));
    }

    public function store(BieuMauRequest $request, int $loai)
    {
        $loaiBieuMau = LoaiBieuMau::tryFrom($loai);

        abort_if(! $loaiBieuMau, 404);

        $data = $request->validated();
        $file = $request->file('file');

        BieuMau::create([
            'loai' => $loaiBieuMau->value,
            'ten' => $data['ten'],
            'file_path' => $file->store('bieu-mau', 'public'),
            'file_name_goc' => $file->getClientOriginalName(),
        ]);

        return redirect()->route('bieumau.index', ['loai' => $loaiBieuMau->value])
            ->with('success', 'Tải lên biểu mẫu thành công');
    }

    public function update(BieuMauRequest $request, BieuMau $bieumau)
    {
        $data = $request->validated();
        $capNhat = ['ten' => $data['ten']];

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($bieumau->file_path);
            $file = $request->file('file');
            $capNhat['file_path'] = $file->store('bieu-mau', 'public');
            $capNhat['file_name_goc'] = $file->getClientOriginalName();
        }

        $bieumau->update($capNhat);

        return redirect()->route('bieumau.index', ['loai' => $bieumau->loai->value])
            ->with('success', 'Cập nhật biểu mẫu thành công');
    }

    public function destroy(BieuMau $bieumau)
    {
        $loai = $bieumau->loai->value;

        Storage::disk('public')->delete($bieumau->file_path);
        $bieumau->delete();

        return redirect()->route('bieumau.index', ['loai' => $loai])
            ->with('success', 'Xoá biểu mẫu thành công');
    }
}