<?php

namespace App\Enum;

use App\Traits\EnumValues;
use App\Traits\EnumOptions;

enum ChucDanhGiaoVien: int
{
    use EnumValues, EnumOptions;

    case THAY_PHU_TRACH = 1;
    case TRO_GIANG = 2;
    case LANH_DAO = 3;
    case VAN_PHONG = 4;

    public function getLabel(): string
    {
        return match ($this) {
            self::THAY_PHU_TRACH => 'Thầy phụ trách',
            self::TRO_GIANG => 'CTV Hỗ trợ bóng đá',
            self::LANH_DAO => 'Lãnh đạo',
            self::VAN_PHONG => 'Văn phòng',
        };
    }

    public function getBadge(): string
    {
        return match ($this) {
            self::THAY_PHU_TRACH => 'blue',
            self::TRO_GIANG => 'purple',
            self::LANH_DAO => 'red',
            self::VAN_PHONG => 'orange',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::THAY_PHU_TRACH => 'ri-graduation-cap-line',
            self::TRO_GIANG => 'ri-user-follow-line',
            self::LANH_DAO => 'ri-user-star-line',
            self::VAN_PHONG => 'ri-briefcase-4-line',
        };
    }

    public function laNhomNhanVien(): bool
    {
        return in_array($this, [self::THAY_PHU_TRACH, self::LANH_DAO, self::VAN_PHONG], true);
    }

    public static function nhomNhanVienValues(): array
    {
        return [self::THAY_PHU_TRACH->value, self::LANH_DAO->value, self::VAN_PHONG->value];
    }
}