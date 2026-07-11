<?php

namespace App\Enum;

enum TrangThaiDiemDanh: int
{
    case DI_HOC = 1;
    case VANG = 2;

    public function getLabel(): string
    {
        return match ($this) {
            self::DI_HOC => 'Đi học',
            self::VANG => 'Vắng',
        };
    }

    public function getBadge(): string
    {
        return match ($this) {
            self::DI_HOC => 'green',
            self::VANG => 'red',
        };
    }
}