<?php

namespace App\Enum;

use App\Traits\EnumValues;
use App\Traits\EnumOptions;

enum ChucDanhGiaoVien: int
{
    use EnumValues, EnumOptions;

    case THAY_PHU_TRACH = 1;
    case TRO_GIANG = 2;

    public function getLabel(): string
    {
        return match ($this) {
            self::THAY_PHU_TRACH => 'Thầy phụ trách',
            self::TRO_GIANG => 'Trợ giảng',
        };
    }

    public function getBadge(): string
    {
        return match ($this) {
            self::THAY_PHU_TRACH => 'blue',
            self::TRO_GIANG => 'purple',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::THAY_PHU_TRACH => 'fas fa-chalkboard-teacher me-1',
            self::TRO_GIANG => 'fas fa-user-friends me-1',
        };
    }
}