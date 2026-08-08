<?php

namespace App\Enum;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum LoaiHoaDon: int
{
    use EnumOptions, EnumValues;

    case DUNG_CU = 1;
    case AN_UONG = 2;
    case DONG_PHUC = 3;
    case TO_ROI = 4;
    case KHAC = 5;

    public function getLabel(): string
    {
        return match ($this) {
            self::DUNG_CU => 'Hóa đơn Dụng cụ',
            self::AN_UONG => 'Hóa đơn Ăn uống',
            self::DONG_PHUC => 'Hóa đơn Đồng phục',
            self::TO_ROI => 'Hóa đơn Tờ rơi',
            self::KHAC => 'Hóa đơn Khác',
        };
    }

    public function getAnh(): string
    {
        return match ($this) {
            self::DUNG_CU => 'images/hoa-don/hoa-don-dung-cu.png',
            self::AN_UONG => 'images/hoa-don/hoa-don-an-uong.png',
            self::DONG_PHUC => 'images/hoa-don/hoa-don-dong-phuc.png',
            self::TO_ROI => 'images/hoa-don/hoa-don-to-roi.png',
            self::KHAC => 'images/hoa-don/hoa-don-khac.png',
        };
    }
}
