<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HocPhi extends Model
{
    use HasFactory;

    protected $table = 'hoc_phis';

    protected $fillable = ['hoc_vien_id', 'gioi_thieu_ban', 'nguoi_gioi_thieu_id', 'thang', 'hoc_phi', 'dong_phuc', 'dong_phuc_size', 'ngay_dong'];

    protected $casts = [
        'thang' => 'date',
        'ngay_dong' => 'date',
        'gioi_thieu_ban' => 'boolean',
    ];

    public function hocVien(): BelongsTo
    {
        return $this->belongsTo(HocVien::class);
    }

    public function nguoiGioiThieu(): BelongsTo
    {
        return $this->belongsTo(HocVien::class, 'nguoi_gioi_thieu_id');
    }
}
