<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhieuLuongCtv extends Model
{
    use HasFactory;

    protected $table = 'phieu_luong_ctvs';

    protected $fillable = [
        'giao_vien_id',
        'thang',
        'ho_ten_snapshot',
        'ma_nhan_vien_snapshot',
        'tong_so_gio',
        'don_gia',
        'thanh_tien',
        'khau_tru',
        'thuc_nhan',
        'updated_by_user_id',
    ];

    protected $casts = [
        'thang' => 'date',
        'tong_so_gio' => 'float',
    ];

    public function giaoVien(): BelongsTo
    {
        return $this->belongsTo(GiaoVien::class);
    }
}