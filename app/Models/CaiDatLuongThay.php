<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaiDatLuongThay extends Model
{
    protected $table = 'cai_dat_luong_thays';

    protected $fillable = [
        'ngay_cong_toi_thieu',
        'tien_tru_1_ngay',
    ];

    public static function hienTai(): self
    {
        return static::query()->first() ?? static::create([
            'ngay_cong_toi_thieu' => 19,
            'tien_tru_1_ngay' => 0,
        ]);
    }

    public static function luu(int $ngayCongToiThieu, int $tienTru1Ngay): void
    {
        $dong = static::query()->first();

        if ($dong) {
            $dong->update([
                'ngay_cong_toi_thieu' => $ngayCongToiThieu,
                'tien_tru_1_ngay' => $tienTru1Ngay,
            ]);
        } else {
            static::create([
                'ngay_cong_toi_thieu' => $ngayCongToiThieu,
                'tien_tru_1_ngay' => $tienTru1Ngay,
            ]);
        }
    }
}