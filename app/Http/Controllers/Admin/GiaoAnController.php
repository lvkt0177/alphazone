<?php

namespace App\Http\Controllers\Admin;

use App\Enum\CapHocGiaoAn;
use App\Enum\ChuDeGiaoAn;
use App\Enum\LoaiGameGiaoAn;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GiaoAn\GiaoAnRequest;
use App\Models\GiaoAn;
use App\Models\SodoMauSac;
use App\Support\SoDoRenderer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GiaoAnController extends Controller
{
    public function index(Request $request)
    {
        [$capHoc, $loaiGame, $chuDe] = $this->layBoLoc($request);

        abort_if(! $capHoc || ! $loaiGame, 404);

        $query = GiaoAn::where('cap_hoc', $capHoc)->where('loai_game', $loaiGame);

        if ($chuDe) {
            $query->where('chu_de', $chuDe);
        } else {
            $query->whereNull('chu_de');
        }

        $giaoAns = $query->orderBy('id')->paginate(20)->withQueryString();

        return view('giaoan.index', compact('giaoAns', 'capHoc', 'loaiGame', 'chuDe'));
    }

    public function create(Request $request)
    {
        [$capHoc, $loaiGame, $chuDe] = $this->layBoLoc($request);

        abort_if(! $capHoc || ! $loaiGame, 404);

        return view('giaoan.create', compact('capHoc', 'loaiGame', 'chuDe'));
    }

    public function store(GiaoAnRequest $request)
    {
        $data = $request->validated();

        // Quan trọng: so_do gửi lên là chuỗi JSON (từ hidden input) — phải decode thành mảng PHP
        // trước khi gán, nếu không Eloquent (cast 'array') sẽ json_encode chuỗi này thêm 1 lần nữa
        // gây lỗi double-encode, khiến lúc mở lại trang Sửa không đọc lại được sơ đồ đã lưu.
        if (isset($data['so_do'])) {
            $data['so_do'] = json_decode($data['so_do'], true) ?: null;
        }

        if ($request->hasFile('video')) {
            $data['video_path'] = $request->file('video')->store('giaoan-videos', 'public');
        }

        GiaoAn::create($data);

        return redirect()->route('giaoan.index', [
            'cap_hoc' => $data['cap_hoc'],
            'loai_game' => $data['loai_game'],
            'chu_de' => $data['chu_de'] ?? null,
        ])->with('success', 'Thêm giáo án thành công');
    }

    public function edit(GiaoAn $giaoan)
    {
        return view('giaoan.edit', ['giaoAn' => $giaoan]);
    }

    // N4: Trang xem chi tiết Giáo án — đứng riêng, không dùng layout admin, để in ra được.
    public function show(GiaoAn $giaoan)
    {
        $mauSac = SodoMauSac::hienTai();
        $sodoMarkup = SoDoRenderer::render($giaoan->so_do, $mauSac);

        return view('giaoan.show', compact('giaoan', 'sodoMarkup'));
    }

    public function update(GiaoAnRequest $request, GiaoAn $giaoan)
    {
        $data = $request->validated();

        if (isset($data['so_do'])) {
            $data['so_do'] = json_decode($data['so_do'], true) ?: null;
        }

        if ($request->hasFile('video')) {
            if ($giaoan->video_path) {
                Storage::disk('public')->delete($giaoan->video_path);
            }
            $data['video_path'] = $request->file('video')->store('giaoan-videos', 'public');
        }

        $giaoan->update($data);

        return redirect()->route('giaoan.index', [
            'cap_hoc' => $giaoan->cap_hoc->value,
            'loai_game' => $giaoan->loai_game->value,
            'chu_de' => $giaoan->chu_de?->value,
        ])->with('success', 'Cập nhật giáo án thành công');
    }

    public function destroy(GiaoAn $giaoan)
    {
        if ($giaoan->video_path) {
            Storage::disk('public')->delete($giaoan->video_path);
        }

        $capHoc = $giaoan->cap_hoc->value;
        $loaiGame = $giaoan->loai_game->value;
        $chuDe = $giaoan->chu_de?->value;

        $giaoan->delete();

        return redirect()->route('giaoan.index', [
            'cap_hoc' => $capHoc,
            'loai_game' => $loaiGame,
            'chu_de' => $chuDe,
        ])->with('success', 'Xoá giáo án thành công');
    }

    private function layBoLoc(Request $request): array
    {
        $capHoc = $request->filled('cap_hoc') ? CapHocGiaoAn::tryFrom((int) $request->query('cap_hoc')) : null;
        $loaiGame = $request->filled('loai_game') ? LoaiGameGiaoAn::tryFrom((int) $request->query('loai_game')) : null;
        $chuDe = $request->filled('chu_de') ? ChuDeGiaoAn::tryFrom((int) $request->query('chu_de')) : null;

        return [$capHoc, $loaiGame, $chuDe];
    }

    public function capNhatMauSac(Request $request)
    {
        $data = $request->validate([
            'blue' => ['required', 'string', 'max:9'],
            'green' => ['required', 'string', 'max:9'],
            'yellow' => ['required', 'string', 'max:9'],
            'orange' => ['required', 'string', 'max:9'],
        ]);

        SodoMauSac::luu($data);

        return response()->json([
            'success' => true,
            'mau_sac' => $data,
        ]);
    }
}