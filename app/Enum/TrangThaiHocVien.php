<?php

namespace App\Enum;

enum TrangThaiHocVien: int
{
    case KHACH_HANG = 1;
    case TAM_NGHI = 2;
    case QUAY_LAI = 3;

    public function getLabel(): string
    {
        return match ($this) {
            self::KHACH_HANG => 'Khách hàng',
            self::TAM_NGHI => 'Tạm nghỉ',
            self::QUAY_LAI => 'Quay lại',
        };
    }

    public function getBadge(): string
    {
        return match ($this) {
            self::KHACH_HANG => 'green',
            self::TAM_NGHI => 'orange',
            self::QUAY_LAI => 'blue',
        };
    }
}