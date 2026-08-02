<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enum\TrangThaiGiaoVien;
use App\Enum\ChucDanhGiaoVien;

class GiaoVien extends Model
{
    use HasFactory;

    protected $table = 'giao_viens';

    protected $fillable = [
        'ho_ten',
        'ma_nhan_vien',
        'cccd',
        'ngay_sinh',
        'sdt',
        'trang_thai',
        'chuc_danh',
        'luong_co_ban',
        'don_gia_gio',
    ];

    protected $casts = [
        'ngay_sinh' => 'date',
        'trang_thai' => TrangThaiGiaoVien::class,
        'chuc_danh' => ChucDanhGiaoVien::class,
    ];

    public function getKyTuDauAttribute(): string
    {
        $parts = preg_split('/\s+/', trim($this->ho_ten ?? ''));
        $dau = $parts[0] ?? '';
        $cuoi = end($parts) ?: '';

        return mb_strtoupper(mb_substr($dau, 0, 1).mb_substr($cuoi, 0, 1));
    }

    public function coSos()
    {
        return $this->hasMany(CoSo::class, 'giao_vien_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'giao_vien_id');
    }

    public function diemDanhs()
    {
        return $this->hasMany(DiemDanh::class, 'giao_vien_id');
    }
}