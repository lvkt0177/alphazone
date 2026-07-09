<?php

namespace App\Enum;

enum GioiTinh: int
{
    case NAM = 1;
    case NU = 2;

    public function getLabel(): string
    {
        return match ($this) {
            self::NAM => 'Nam',
            self::NU => 'Nữ',
        };
    }
}