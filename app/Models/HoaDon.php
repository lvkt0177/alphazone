<?php

namespace App\Models;

use App\Enum\LoaiHoaDon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoaDon extends Model
{
    use HasFactory;

    protected $table = 'hoa_dons';

    protected $fillable = [
        'loai',
        'ten',
        'ngay_tao',
        'file_path',
        'file_name_goc',
    ];

    protected $casts = [
        'loai' => LoaiHoaDon::class,
        'ngay_tao' => 'date',
    ];
}
