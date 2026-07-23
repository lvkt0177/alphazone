<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class DiaDiem extends Model
{
    use HasFactory;

    protected $table = 'dia_diems';

    protected $fillable = ['ten'];

    public function coSos(): HasMany
    {
        return $this->hasMany(CoSo::class);
    }

    public function tienSans(): HasManyThrough
    {
        return $this->hasManyThrough(TienSan::class, CoSo::class);
    }
}