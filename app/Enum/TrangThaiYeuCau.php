<?php
namespace App\Enum;

enum TrangThaiYeuCau: int
{
    case PENDING = 0;
    case APPROVED = 1;

    public function getLabel(): string
    {
        return match($this) {
            self::PENDING => 'Chờ xử lý',
            self::APPROVED => 'Đã duyệt',
        };
    }

    public function getBadge(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::APPROVED => 'success',
        };
    }
}
