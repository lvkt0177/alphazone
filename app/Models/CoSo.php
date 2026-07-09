<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enum\TrangThaiCoSo;

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
}