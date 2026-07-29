<?php

namespace App\Enum;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum LoaiGameGiaoAn: int
{
    use EnumOptions, EnumValues;

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

    public function getAnh(): string
    {
        return match ($this) {
            self::KHOI_DONG => 'images/giao-an/khoi-dong.png',
            self::GAME_1 => 'images/giao-an/game-1.png',
            self::GAME_2 => 'images/giao-an/game-2.png',
            self::GAME_3 => 'images/giao-an/game-3.jpg',
        };
    }
}
