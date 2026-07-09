<?php

namespace App\Enum;

enum TrangThaiLoaiDangKyTraiNghiem: int
{
    case TRUY_CUU = 0;
    case DA_DANG_KY = 1;
    case KHONG_DANG_KY = 2;
    case CHUA_TRAI_NGHIEM = 3;

    public function getLabel(): string
    {
        return match ($this) {
            self::TRUY_CUU => 'Truy cứu',
            self::DA_DANG_KY => 'Đã đăng ký',
            self::KHONG_DANG_KY => 'Không đăng ký',
            self::CHUA_TRAI_NGHIEM => 'Chưa trải nghiệm',
        };
    }

    public function getBadge(): string
    {
        return match ($this) {
            self::TRUY_CUU => 'purple',
            self::DA_DANG_KY => 'green',
            self::KHONG_DANG_KY => 'red',
            self::CHUA_TRAI_NGHIEM => 'gray',
        };
    }
}