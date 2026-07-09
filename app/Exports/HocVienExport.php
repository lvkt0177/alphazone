<?php

namespace App\Exports;

use App\Models\HocVien;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class HocVienExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(protected array $filters = [])
    {
    }

    public function collection(): Collection
    {
        $query = HocVien::with('coSos');

        if (!empty($this->filters['q'])) {
            $q = $this->filters['q'];
            $query->where(fn ($sub) => $sub->where('ma_so', 'like', "%{$q}%")
                                            ->orWhere('ho_ten', 'like', "%{$q}%"));
        }

        if (!empty($this->filters['co_so_id'])) {
            $query->whereHas('coSos', fn ($sub) => $sub->where('co_sos.id', $this->filters['co_so_id']));
        }

        if (isset($this->filters['trang_thai']) && $this->filters['trang_thai'] !== '') {
            $query->where('trang_thai', $this->filters['trang_thai']);
        }

        return $query->orderBy('id', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Mã số', 'Họ tên', 'SĐT',
            'Cơ sở 1', 'Cơ sở 2', 'Cơ sở 3', 'Cơ sở 4', 'Cơ sở 5', 'Cơ sở 6',
            'Trạng thái',
        ];
    }

    public function map($hv): array
    {
        $tenCoSos = $hv->coSos->pluck('ten')->values();

        return [
            $hv->ma_so,
            $hv->ho_ten,
            $hv->sdt ?? '',
            $tenCoSos->get(0) ?? '',
            $tenCoSos->get(1) ?? '',
            $tenCoSos->get(2) ?? '',
            $tenCoSos->get(3) ?? '',
            $tenCoSos->get(4) ?? '',
            $tenCoSos->get(5) ?? '',
            $hv->trang_thai->getLabel(),
        ];
    }
}