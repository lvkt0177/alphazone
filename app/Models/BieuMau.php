<?php

namespace App\Models;

use App\Enum\LoaiBieuMau;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BieuMau extends Model
{
    use HasFactory;

    protected $table = 'bieu_maus';

    protected $fillable = [
        'loai',
        'ten',
        'file_path',
        'file_name_goc',
    ];

    protected $casts = [
        'loai' => LoaiBieuMau::class,
    ];
}