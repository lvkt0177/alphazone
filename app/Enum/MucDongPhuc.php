<?php

namespace App\Enum;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum MucDongPhuc: int
{
    use EnumOptions, EnumValues;

    case MUC_0k = 0;
    case MUC_250K = 250000;
    case MUC_175K = 175000;

    public function getLabel(): string
    {
        return match ($this) {
            self::MUC_0k => 'Được tặng/ miễn phí',
            self::MUC_250K => '250.000đ',
            self::MUC_175K => '175.000đ',
        };
    }
}
