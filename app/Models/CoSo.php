<?php

namespace App\Models;

use App\Enum\TrangThaiCoSo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CoSo extends Model
{
    use HasFactory;

    protected $table = 'co_sos';

    protected $fillable = [
        'ten',
        'giao_vien_id',
        'trang_thai',
    ];

    protected $casts = [
        'trang_thai' => TrangThaiCoSo::class,
    ];

    public function giaoVien(): BelongsTo
    {
        return $this->belongsTo(GiaoVien::class, 'giao_vien_id');
    }

    /**
     * C2
     * "Tên Cơ sở - Người phụ trách" (vd: Cơ sở A - Nguyễn Văn B)
     */
    public function getNhanHienThiAttribute(): string
    {
        return "{$this->ten} - {$this->giaoVien->ho_ten}";
    }

    public function hocVienTraiNghiems(): BelongsToMany
    {
        return $this->belongsToMany(
            HocVienTraiNghiem::class,
            'hoc_vien_trai_nghiem_co_so',
            'co_so_id',
            'hoc_vien_trai_nghiem_id'
        )->withTimestamps();
    }

    public function hocViens(): BelongsToMany
    {
        return $this->belongsToMany(HocVien::class, 'hoc_vien_co_so', 'co_so_id', 'hoc_vien_id')->withTimestamps();
    }

    public function tienSans(): HasMany
    {
        return $this->hasMany(TienSan::class);
    }
}
