<?php

namespace App\Models;

use App\Enum\TrangThaiLoaiDangKyTraiNghiem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class HocVienTraiNghiem extends Model
{
    use HasFactory;

    protected $table = 'hoc_vien_trai_nghiems';

    protected $fillable = [
        'ho_ten',
        'nam_sinh',
        'sdt',
        'ngay_trai_nghiem',
        'trang_thai',
        'ghi_chu',
    ];

    protected $casts = [
        'trang_thai' => TrangThaiLoaiDangKyTraiNghiem::class,
        'ngay_trai_nghiem' => 'date',
    ];

    public function coSos(): BelongsToMany
    {
        return $this->belongsToMany(
            CoSo::class,
            'hoc_vien_trai_nghiem_co_so',
            'hoc_vien_trai_nghiem_id',
            'co_so_id'
        )->withTimestamps();
    }
}
