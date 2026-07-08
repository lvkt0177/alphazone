<?php

namespace App\Enum;

enum LoaiDangKyTraiNghiem: int
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
            self::TRUY_CUU => 'info text-white',
            self::DA_DANG_KY => 'success text-white',
            self::KHONG_DANG_KY => 'danger text-white',
            self::CHUA_TRAI_NGHIEM => 'secondary text-white',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::TRUY_CUU => 'fas fa-search me-1',
            self::DA_DANG_KY => 'fas fa-check-circle me-1',
            self::KHONG_DANG_KY => 'fas fa-times-circle me-1',
            self::CHUA_TRAI_NGHIEM => 'fas fa-clock me-1',
        };
    }
}