<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Enum\TrangThaiLoaiDangKyTraiNghiem;

class HocVienTraiNghiem extends Model
{
    use HasFactory;

    protected $table = 'hoc_vien_trai_nghiems';

    protected $fillable = [
        'ho_ten',
        'nam_sinh',
        'trang_thai',
        'ghi_chu',
    ];

    protected $casts = [
        'trang_thai' => TrangThaiLoaiDangKyTraiNghiem::class,
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