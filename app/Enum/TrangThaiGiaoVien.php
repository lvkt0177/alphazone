<?php

namespace App\Enum;

use App\Traits\EnumValues;
use App\Traits\EnumOptions;

enum TrangThaiGiaoVien: int
{
    use EnumValues, EnumOptions;

    case DANG_DAY = 1;
    case DA_NGHI = 0;

    public function getLabel(): string
    {
        return match ($this) {
            self::DANG_DAY => 'Đang dạy', 
            self::DA_NGHI => 'Đã nghỉ', 
        };
    }

    public function getBadge(): string
    {
        return match ($this) {
            self::DANG_DAY => 'green', 
            self::DA_NGHI => 'gray', 
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::DANG_DAY => 'fas fa-check-circle me-1', 
            self::DA_NGHI => 'fas fa-times-circle me-1', 
        };
    }


}
