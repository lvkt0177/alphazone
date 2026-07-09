<?php

namespace App\Enum;

enum TrangThaiCoSo: int
{
    case ACTIVE = 1;
    case INACTIVE = 0;

    public function getLabel(): string
    {
        return match ($this) {
            self::ACTIVE => 'Hoạt động',
            self::INACTIVE => 'Ngừng hoạt động',
        };
    }

    public function getBadge(): string
    {
        return match ($this) {
            self::ACTIVE => 'green',
            self::INACTIVE => 'gray',
        };
    }
}
