<?php

namespace App\Enum;

use App\Traits\EnumValues;
use App\Traits\EnumOptions;

enum ChuDeGiaoAn: int
{
    use EnumValues, EnumOptions;

    case CD_1 = 1;
    case CD_2 = 2;
    case CD_3 = 3;
    case CD_4 = 4;
    case CD_5 = 5;
    case CD_6 = 6;

    public function getLabel(): string
    {
        return match ($this) {
            self::CD_1 => 'Chuyền bóng & Kiểm soát bóng',
            self::CD_2 => 'Dẫn bóng & Qua người',
            self::CD_3 => 'Sút bóng & Tấn công',
            self::CD_4 => 'Phòng ngự',
            self::CD_5 => 'Di chuyển không bóng & Tổ chức',
            self::CD_6 => 'Tổng hợp',
        };
    }

    public function getLabelCoSo(): string
    {
        return "CĐ{$this->value}: {$this->getLabel()}";
    }
}