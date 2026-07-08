<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiaoVien extends Model
{
    use HasFactory;

    protected $table = 'giao_viens';

    protected $fillable = [
        'ho_ten',
        'ngay_sinh',
        'sdt',
    ];

    protected $casts = [
        'ngay_sinh' => 'date',
    ];

    public function coSos()
    {
        return $this->hasMany(CoSo::class, 'giao_vien_id');
    }
}