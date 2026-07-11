<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HocPhi extends Model
{
    use HasFactory;

    protected $table = 'hoc_phis';

    protected $fillable = ['hoc_vien_id', 'thang', 'hoc_phi', 'dong_phuc', 'ngay_dong'];

    protected $casts = [
        'thang' => 'date',
        'ngay_dong' => 'date',
    ];

    public function hocVien(): BelongsTo
    {
        return $this->belongsTo(HocVien::class);
    }
}
