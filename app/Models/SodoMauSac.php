<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SodoMauSac extends Model
{
    protected $table = 'sodo_mau_sac';

    protected $fillable = [
        'mau_sac',
    ];

    protected $casts = [
        'mau_sac' => 'array',
    ];

    public static function macDinh(): array
    {
        return [
            'blue' => '#0ffdfd',
            'green' => '#0af15f',
            'yellow' => '#fffc32',
            'orange' => '#ffcf66',
        ];
    }

    public static function hienTai(): array
    {
        $dong = static::query()->first();

        if (! $dong || ! is_array($dong->mau_sac)) {
            return static::macDinh();
        }

        return array_merge(static::macDinh(), $dong->mau_sac);
    }

    public static function luu(array $mauSac): void
    {
        $dong = static::query()->first();

        if ($dong) {
            $dong->update(['mau_sac' => $mauSac]);
        } else {
            static::create(['mau_sac' => $mauSac]);
        }
    }
}