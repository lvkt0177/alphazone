<?php

namespace App\Http\Controllers\Admin;

use App\Enum\LoaiBieuMau;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BieuMau\BieuMauMauTrongRequest;
use App\Http\Requests\Admin\BieuMau\BieuMauRequest;
use App\Models\BieuMau;
use App\Models\BieuMauMauTrong;
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

        $mauTrong = BieuMauMauTrong::where('loai', $loaiBieuMau->value)->first();

        return view('bieumau.index', compact('loaiBieuMau', 'bieuMaus', 'mauTrong'));
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

    public function download(BieuMau $bieumau)
    {
        abort_unless(Storage::disk('public')->exists($bieumau->file_path), 404);

        return Storage::disk('public')->download($bieumau->file_path, $bieumau->file_name_goc);
    }

    public function uploadMauTrong(BieuMauMauTrongRequest $request, int $loai)
    {
        $loaiBieuMau = LoaiBieuMau::tryFrom($loai);

        abort_if(! $loaiBieuMau, 404);

        $file = $request->file('file');
        $mauTrong = BieuMauMauTrong::firstOrNew(['loai' => $loaiBieuMau->value]);

        if ($mauTrong->exists) {
            Storage::disk('public')->delete($mauTrong->file_path);
        }

        $mauTrong->fill([
            'file_path' => $file->store('bieu-mau-trong', 'public'),
            'file_name_goc' => $file->getClientOriginalName(),
            'updated_by_user_id' => auth()->id(),
        ])->save();

        return redirect()->route('bieumau.index', ['loai' => $loaiBieuMau->value])
            ->with('success', 'Cập nhật mẫu trống thành công');
    }

    public function downloadMauTrong(int $loai)
    {
        $loaiBieuMau = LoaiBieuMau::tryFrom($loai);

        abort_if(! $loaiBieuMau, 404);

        $mauTrong = BieuMauMauTrong::where('loai', $loaiBieuMau->value)->first();

        abort_if(! $mauTrong || ! Storage::disk('public')->exists($mauTrong->file_path), 404);

        return Storage::disk('public')->download($mauTrong->file_path, $mauTrong->file_name_goc);
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