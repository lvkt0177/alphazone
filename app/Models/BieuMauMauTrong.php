<?php

namespace App\Models;

use App\Enum\LoaiBieuMau;
use Illuminate\Database\Eloquent\Model;

class BieuMauMauTrong extends Model
{
    protected $table = 'bieu_mau_mau_trongs';

    protected $fillable = [
        'loai',
        'file_path',
        'file_name_goc',
        'updated_by_user_id',
    ];

    protected $casts = [
        'loai' => LoaiBieuMau::class,
    ];
}