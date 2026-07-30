<?php

namespace App\Enum;

use App\Traits\EnumValues;
use App\Traits\EnumOptions;

enum RoleUser: int
{
    use EnumValues, EnumOptions;

    case ADMIN = 1;
    case GIAO_VIEN = 2;

    public function getLabel(): string
    {
        return match ($this) {
            self::ADMIN => 'Quản trị viên',
            self::GIAO_VIEN => 'Giáo viên',
        };
    }

    public function getBadge(): string
    {
        return match ($this) {
            self::ADMIN => 'red',
            self::GIAO_VIEN => 'blue',
        };
    }
}