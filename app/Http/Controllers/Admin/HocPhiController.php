<?php

namespace App\Http\Controllers\Admin;

use App\Enum\TrangThaiDiemDanh;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HocPhi\HocPhiRequest;
use App\Models\CoSo;
use App\Models\HocPhi;
use App\Models\HocVien;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HocPhiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->filled('tu_ngay') && $request->filled('den_ngay')) {
            return $this->indexTheoKhoangNgay($request);
        }

        $thangInput = $request->input('thang') ?: now()->format('Y-m');
        $thang = Carbon::createFromFormat('Y-m', $thangInput)->startOfMonth();

        $thangTruoc = $thang->copy()->subMonth();

        $query = HocVien::with([
            'coSos',
            'hocPhis' => fn ($q) => $q->where('thang', $thang->toDateString())->with('nguoiGioiThieu'),
            'diemDanhs' => fn ($q) => $q->whereBetween('ngay', [
                $thangTruoc->toDateString(),
                $thangTruoc->copy()->endOfMonth()->toDateString(),
            ])->where('trang_thai', TrangThaiDiemDanh::DI_HOC),
        ]);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(fn ($sub) => $sub->where('ma_so', 'like', "%{$q}%")
                ->orWhereUnaccentedLike('ho_ten', $q)
                ->orWhere('sdt', 'like', "%{$q}%"));
        }

        if ($request->filled('co_so_id')) {
            $coSoId = $request->co_so_id;
            $query->whereHas('coSos', fn ($sub) => $sub->where('co_sos.id', $coSoId));
        }

        if ($request->trang_thai_dong === 'da_dong') {
            $query->whereHas('hocPhis', fn ($sub) => $sub->where('thang', $thang->toDateString()));
        } elseif ($request->trang_thai_dong === 'chua_dong') {
            $query->whereDoesntHave('hocPhis', fn ($sub) => $sub->where('thang', $thang->toDateString()));
        }

        $hocViens = $query->orderBy('ho_ten')->paginate(10)->withQueryString();

        $danhSachThang = collect(range(-6, 11))->map(function ($i) {
            $d = now()->subMonths($i)->startOfMonth();

            return [
                'value' => $d->format('Y-m'),
                'label' => 'Tháng '.$d->format('n/Y').($i < 0 ? ' (sắp tới)' : ''),
            ];
        });

        $countBaseQuery = HocVien::when($request->filled('co_so_id'), function ($q) use ($request) {
            $q->whereHas('coSos', fn ($sub) => $sub->where('co_sos.id', $request->co_so_id));
        });

        $countDaDong = (clone $countBaseQuery)
            ->whereHas('hocPhis', fn ($sub) => $sub->where('thang', $thang->toDateString()))
            ->count();
        $countChuaDong = (clone $countBaseQuery)
            ->whereDoesntHave('hocPhis', fn ($sub) => $sub->where('thang', $thang->toDateString()))
            ->count();

        $tongHocPhiThang = HocPhi::where('thang', $thang->toDateString())
            ->when($request->filled('co_so_id'), function ($q) use ($request) {
                $q->whereHas('hocVien.coSos', fn ($sub) => $sub->where('co_sos.id', $request->co_so_id));
            })
            ->sum('hoc_phi');

        $coSos = CoSo::orderBy('ten')->get();

        $hocVienOptions = HocVien::select('id', 'ma_so', 'ho_ten')->orderBy('ho_ten')->get();

        return view('tuition.index', compact(
            'hocViens', 'thang', 'danhSachThang', 'countDaDong', 'countChuaDong', 'tongHocPhiThang', 'coSos', 'hocVienOptions'
        ));
    }

    public function store(HocPhiRequest $request)
    {
        $data = $request->validated();
        $thang = Carbon::parse($data['thang'])->startOfMonth()->toDateString();
        $gioiThieuBan = $request->boolean('gioi_thieu_ban');

        HocPhi::updateOrCreate(
            ['hoc_vien_id' => $data['hoc_vien_id'], 'thang' => $thang],
            [
                'gioi_thieu_ban' => $gioiThieuBan,
                'nguoi_gioi_thieu_id' => $gioiThieuBan ? $data['nguoi_gioi_thieu_id'] : null,
                'hoc_phi' => $gioiThieuBan ? 0 : ($data['hoc_phi'] ?? 0),
                'dong_phuc' => $data['dong_phuc'] ?? null,
                'dong_phuc_size' => $data['dong_phuc_size'] ?? null,
                'ngay_dong' => $data['ngay_dong'],
            ]
        );

        $hocVien = HocVien::where('id', $data['hoc_vien_id'])->first();

        return redirect()
            ->route('hocphi.index', ['thang' => Carbon::parse($thang)->format('Y-m')])
            ->with('success', "Lưu học phí thành công cho học viên \"{$hocVien->ho_ten}\"");
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

    private function indexTheoKhoangNgay(Request $request)
    {
        try {
            $tuNgay = Carbon::parse($request->tu_ngay)->startOfDay();
            $denNgay = Carbon::parse($request->den_ngay)->endOfDay();
        } catch (\Exception $e) {
            $request->query->remove('tu_ngay');
            $request->query->remove('den_ngay');

            return $this->index($request);
        }

        if ($tuNgay->greaterThan($denNgay)) {
            [$tuNgay, $denNgay] = [$denNgay->copy()->startOfDay(), $tuNgay->copy()->endOfDay()];
        }

        $apDungLoc = function ($query, ?string $quaHocVien = null) use ($request) {
            if ($request->filled('q')) {
                $q = $request->q;
                $dieuKien = function ($sub) use ($q) {
                    $sub->where('ma_so', 'like', "%{$q}%")
                        ->orWhereUnaccentedLike('ho_ten', $q)
                        ->orWhere('sdt', 'like', "%{$q}%");
                };
                $quaHocVien
                    ? $query->whereHas($quaHocVien, $dieuKien)
                    : $query->where(fn ($sub) => $dieuKien($sub));
            }

            if ($request->filled('co_so_id')) {
                $coSoId = $request->co_so_id;
                $dieuKien = fn ($sub) => $sub->whereHas('coSos', fn ($s) => $s->where('co_sos.id', $coSoId));
                $quaHocVien
                    ? $query->whereHas($quaHocVien, $dieuKien)
                    : $query->where(fn ($sub) => $dieuKien($sub));
            }
        };

        $daDongQuery = HocPhi::with('hocVien')
            ->whereHas('hocVien')
            ->whereBetween('ngay_dong', [$tuNgay, $denNgay]);
        $apDungLoc($daDongQuery, 'hocVien');
        $daDongList = $daDongQuery->orderBy('ngay_dong')->paginate(15, ['*'], 'trang_da_dong')->withQueryString();

        $chuaDongQuery = HocVien::with('coSos')->whereDoesntHave('hocPhis', function ($q) use ($tuNgay, $denNgay) {
            $q->whereBetween('ngay_dong', [$tuNgay, $denNgay]);
        });
        $apDungLoc($chuaDongQuery);
        $chuaDongList = $chuaDongQuery->orderBy('ho_ten')->paginate(15, ['*'], 'trang_chua_dong')->withQueryString();

        $coSos = CoSo::orderBy('ten')->get();
        $hocVienOptions = HocVien::select('id', 'ma_so', 'ho_ten')->orderBy('ho_ten')->get();

        return view('tuition.index', [
            'dangLocNgay' => true,
            'daDongList' => $daDongList,
            'chuaDongList' => $chuaDongList,
            'coSos' => $coSos,
            'hocVienOptions' => $hocVienOptions,
        ]);
    }
}