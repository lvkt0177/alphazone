<?php

namespace App\Enum;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum CapHocGiaoAn: int
{
    use EnumOptions, EnumValues;

    case MAM_NON = 1;
    case TIEU_HOC = 2;
    case CAP_2 = 3;

    public function getLabel(): string
    {
        return match ($this) {
            self::MAM_NON => 'Mầm non',
            self::TIEU_HOC => 'Tiểu học',
            self::CAP_2 => 'Cấp 2',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::MAM_NON => 'ri-emotion-happy-line',
            self::TIEU_HOC => 'ri-book-open-line',
            self::CAP_2 => 'ri-football-line',
        };
    }

    public function getAnh(): string
    {
        return match ($this) {
            self::MAM_NON => 'images/giao-an/mam-non.jpg',
            self::TIEU_HOC => 'images/giao-an/tieu-hoc.png',
            self::CAP_2 => 'images/giao-an/cap-2.jpg',
        };
    }

    public function danhSachLoaiGame(): array
    {
        return match ($this) {
            self::MAM_NON => [
                LoaiGameGiaoAn::KHOI_DONG,
                LoaiGameGiaoAn::GAME_1,
                LoaiGameGiaoAn::GAME_2,
            ],
            self::TIEU_HOC, self::CAP_2 => [
                LoaiGameGiaoAn::KHOI_DONG,
                LoaiGameGiaoAn::GAME_1,
                LoaiGameGiaoAn::GAME_2,
                LoaiGameGiaoAn::GAME_3,
            ],
        };
    }

    public function coChuDe(): bool
    {
        return $this !== self::MAM_NON;
    }
}
