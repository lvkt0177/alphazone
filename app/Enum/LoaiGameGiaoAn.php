<?php

namespace App\Enum;

use App\Traits\EnumValues;
use App\Traits\EnumOptions;

enum LoaiGameGiaoAn: int
{
    use EnumValues, EnumOptions;

    case KHOI_DONG = 1;
    case GAME_1 = 2;
    case GAME_2 = 3;
    case GAME_3 = 4;

    public function getLabel(): string
    {
        return match ($this) {
            self::KHOI_DONG => 'Khởi động',
            self::GAME_1 => 'Game 1',
            self::GAME_2 => 'Game 2',
            self::GAME_3 => 'Game 3',
        };
    }

    public function getLabelCoSo(): string
    {
        return "{$this->value}. {$this->getLabel()}";
    }
}