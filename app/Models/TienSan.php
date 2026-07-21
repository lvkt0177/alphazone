<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TienSan extends Model
{
    use HasFactory;

    protected $table = 'tien_sans';

    protected $fillable = ['co_so_id', 'ngay', 'so_tien', 'ghi_chu'];

    protected $casts = [
        'ngay' => 'date',
    ];

    public function coSo(): BelongsTo
    {
        return $this->belongsTo(CoSo::class);
    }
}
