<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class TienSan extends Model
{
    use HasFactory;

    protected $table = 'tien_sans';

    protected $fillable = ['co_so_id', 'ngay', 'so_tien', 'ghi_chu', 'bill'];

    protected $appends = ['bill_url'];

    protected $casts = [
        'ngay' => 'date',
    ];

    public function coSo(): BelongsTo
    {
        return $this->belongsTo(CoSo::class);
    }

    public function getBillUrlAttribute(): ?string
    {
        return $this->bill ? Storage::url($this->bill) : null;
    }
}