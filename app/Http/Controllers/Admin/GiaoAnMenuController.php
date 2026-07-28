<?php

namespace App\Http\Controllers\Admin;

use App\Enum\CapHocGiaoAn;
use App\Enum\ChuDeGiaoAn;
use App\Enum\LoaiGameGiaoAn;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GiaoAnMenuController extends Controller
{
    public function index(Request $request)
    {
        $capHoc = $request->filled('cap_hoc') ? CapHocGiaoAn::tryFrom((int) $request->query('cap_hoc')) : null;

        if (! $capHoc) {
            return view('giaoan.menu', ['buoc' => 'caphoc']);
        }

        $loaiGame = $request->filled('loai_game') ? LoaiGameGiaoAn::tryFrom((int) $request->query('loai_game')) : null;

        if (! $loaiGame) {
            return view('giaoan.menu', [
                'buoc' => 'loaigame',
                'capHoc' => $capHoc,
                'dsLoaiGame' => $capHoc->danhSachLoaiGame(),
            ]);
        }

        if (! in_array($loaiGame, $capHoc->danhSachLoaiGame(), true)) {
            return redirect()->route('giaoan.menu', ['cap_hoc' => $capHoc->value]);
        }

        if (! $capHoc->coChuDe()) {
            return redirect()->route('giaoan.index', [
                'cap_hoc' => $capHoc->value,
                'loai_game' => $loaiGame->value,
            ]);
        }

        $chuDe = $request->filled('chu_de') ? ChuDeGiaoAn::tryFrom((int) $request->query('chu_de')) : null;

        if (! $chuDe) {
            return view('giaoan.menu', [
                'buoc' => 'chude',
                'capHoc' => $capHoc,
                'loaiGame' => $loaiGame,
                'dsChuDe' => ChuDeGiaoAn::cases(),
            ]);
        }

        return redirect()->route('giaoan.index', [
            'cap_hoc' => $capHoc->value,
            'loai_game' => $loaiGame->value,
            'chu_de' => $chuDe->value,
        ]);
    }
}