<?php

namespace App\Models;

use App\Enum\CapHocGiaoAn;
use App\Enum\ChuDeGiaoAn;
use App\Enum\LoaiGameGiaoAn;
use Illuminate\Database\Eloquent\Model;

class GiaoAn extends Model
{
    protected $table = 'giao_ans';

    protected $fillable = [
        'cap_hoc',
        'loai_game',
        'chu_de',
        'ten_tro_choi',
        'cach_choi',
        'luat_choi',
        'so_do',
        'video_path',
    ];

    protected $casts = [
        'cap_hoc' => CapHocGiaoAn::class,
        'loai_game' => LoaiGameGiaoAn::class,
        'chu_de' => ChuDeGiaoAn::class,
        'so_do' => 'array',
    ];

    public function videoUrl(): ?string
    {
        return $this->video_path ? asset('storage/'.$this->video_path) : null;
    }
}