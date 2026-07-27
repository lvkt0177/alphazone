<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaiDatHocPhi extends Model
{
    use HasFactory;

    protected $table = 'cai_dat_hoc_phis';

    protected $fillable = ['so_luong_co_so', 'hoc_phi', 'tong_so_buoi'];

    protected $casts = [
        'so_luong_co_so' => 'integer',
        'hoc_phi' => 'integer',
        'tong_so_buoi' => 'integer',
    ];

    protected $appends = ['gia_1_buoi'];
 
    public function getGia1BuoiAttribute(): int
    {
        if (! $this->tong_so_buoi) {
            return 0;
        }

        return (int) round($this->hoc_phi / $this->tong_so_buoi / 1000) * 1000;
    }

    public static function layTheoSoLuongCoSo(int $soLuongCoSo): ?self
    {
        return static::where('so_luong_co_so', $soLuongCoSo)->first();
    }
}