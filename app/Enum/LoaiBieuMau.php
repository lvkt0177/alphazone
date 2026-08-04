<?php

namespace App\Enum;

use App\Traits\EnumValues;
use App\Traits\EnumOptions;

enum LoaiBieuMau: int
{
    use EnumValues, EnumOptions;

    case HOAN_TAM_UNG = 1;
    case CONG_TAC_PHI = 2;
    case HOAN_DAN_9_CUC = 3;
    case KHAC = 4;
    case BHXH = 5;

    public function getLabel(): string
    {
        return match ($this) {
            self::HOAN_TAM_UNG => 'Biểu Mẫu Hoàn tạm ứng',
            self::CONG_TAC_PHI => 'Biểu Mẫu Công tác phí',
            self::HOAN_DAN_9_CUC => 'Biểu Mẫu Hoàn dân 9 cục',
            self::KHAC => 'Biểu Mẫu khác',
            self::BHXH => 'BHXH',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::HOAN_TAM_UNG => 'ri-refund-2-line',
            self::CONG_TAC_PHI => 'ri-suitcase-3-line',
            self::HOAN_DAN_9_CUC => 'ri-team-line',
            self::KHAC => 'ri-file-list-3-line',
            self::BHXH => 'ri-shield-check-line',
        };
    }

    public function getAnh(): string
    {
        return match ($this) {
            self::HOAN_TAM_UNG => 'images/bieu-mau/bieu-mau-hoan-tien-tam-ung.png',
            self::CONG_TAC_PHI => 'images/bieu-mau/bieu-mau-cong-tac-phi.png',
            self::HOAN_DAN_9_CUC => 'images/bieu-mau/bieu-mau-hoan-dan-9-cuc.png',
            self::KHAC => 'images/bieu-mau/bieu-mau-khac.png',
            self::BHXH => 'images/bieu-mau/bhxh.png',
        };
    }
}