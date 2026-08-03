<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhieuLuongNhanVien extends Model
{
    use HasFactory;

    protected $table = 'phieu_luong_nhan_viens';

    protected $fillable = [
        'giao_vien_id',
        'thang',
        'ngay_chot',
        'ho_ten_snapshot',
        'ma_nhan_vien_snapshot',
        'luong_co_ban',
        'ngay_cong_chuan',
        'so_ngay_co_luong',
        'so_ngay_khong_luong',
        'tro_cap',
        'nang_suat',
        'thuong_khac',
        'tong_thu_nhap',
        'tong_khau_tru',
        'cong_tac_phi',
        'tam_ung',
        'giam_tru_gia_canh',
        'bhxh',
        'bhyt',
        'bhtn',
        'thu_nhap_chiu_thue',
        'tntt',
        'thue_tncn',
        'luong_thuc_nhan',
        'updated_by_user_id',
    ];

    protected $casts = [
        'thang' => 'date',
        'ngay_chot' => 'date',
    ];

    public function giaoVien(): BelongsTo
    {
        return $this->belongsTo(GiaoVien::class);
    }
}