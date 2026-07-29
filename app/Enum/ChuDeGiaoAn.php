<?php

namespace App\Enum;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum ChuDeGiaoAn: int
{
    use EnumOptions, EnumValues;

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

    public function getAnh(): string
    {
        return match ($this) {
            self::CD_1 => 'images/giao-an/chuyen-bong-kiem-soat-bong.jpg',
            self::CD_2 => 'images/giao-an/dan-bong-qua-nguoi.jpg',
            self::CD_3 => 'images/giao-an/sut-bong-tan-cong.jpg',
            self::CD_4 => 'images/giao-an/phong-ngu.jpg',
            self::CD_5 => 'images/giao-an/di-chuyen-khong-bong-to-chuc.jpg',
            self::CD_6 => 'images/giao-an/tong-hop.jpg',
        };
    }
}
