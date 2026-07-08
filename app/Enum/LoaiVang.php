<?php

namespace App\Enum;

enum LoaiVang:int
{
    //
    case COPHEP = 1;
    case KHONGPHEP = 0;

    public function getLabel(): string
    {
        return match ($this) {
            self::COPHEP => 'Có phép', 
            self::KHONGPHEP => 'Không phép', 
        };
    }
}
