<?php

namespace App\Enum;

use App\Traits\EnumValues;
use App\Traits\EnumOptions;

enum HocPhiStatus: int
{
    use EnumValues, EnumOptions;

    case DA_DONG = 1;
    case CHUA_DONG = 0;

    public function getLabel(): string
    {
        return match ($this) {
            self::DA_DONG => 'Đã đóng', 
            self::CHUA_DONG => 'Chưa đóng', 
        };
    }

    public function getBadge(): string
    {
        return match ($this) {
            self::DA_DONG => 'paid', 
            self::CHUA_DONG => 'unpaid', 
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::DA_DONG => 'fas fa-check-circle me-1', 
            self::CHUA_DONG => 'fas fa-times-circle me-1', 
        };
    }


}
