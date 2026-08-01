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
    ];

    protected $casts = [
        'ngay_sinh' => 'date',
        'trang_thai' => TrangThaiGiaoVien::class,
        'chuc_danh' => ChucDanhGiaoVien::class,
    ];

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