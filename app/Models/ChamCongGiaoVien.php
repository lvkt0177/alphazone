<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChamCongGiaoVien extends Model
{
    use HasFactory;

    protected $table = 'cham_cong_giao_viens';

    protected $fillable = [
        'giao_vien_id',
        'ngay',
        'co_di_lam',
        'so_gio',
        'ho_tro_xang_xe',
        'ghi_chu',
        'updated_by_user_id',
    ];

    protected $casts = [
        'ngay' => 'date',
        'co_di_lam' => 'boolean',
        'so_gio' => 'float',
    ];

    public function giaoVien(): BelongsTo
    {
        return $this->belongsTo(GiaoVien::class);
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_user_id');
    }
}
