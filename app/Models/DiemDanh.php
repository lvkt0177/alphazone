<?php

namespace App\Models;

use App\Enum\TrangThaiDiemDanh;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiemDanh extends Model
{
    use HasFactory;

    protected $table = 'diem_danhs';

    protected $fillable = [
        'hoc_vien_id', 'co_so_id', 'giao_vien_id', 'ngay', 'trang_thai', 'ghi_chu',
    ];

    protected $casts = [
        'ngay' => 'date',
        'trang_thai' => TrangThaiDiemDanh::class,
    ];

    public function hocVien(): BelongsTo
    {
        return $this->belongsTo(HocVien::class);
    }

    public function coSo(): BelongsTo
    {
        return $this->belongsTo(CoSo::class);
    }

    public function giaoVien(): BelongsTo
    {
        return $this->belongsTo(GiaoVien::class);
    }
}
