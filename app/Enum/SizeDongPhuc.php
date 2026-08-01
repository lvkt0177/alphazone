<?php

namespace App\Enum;

use App\Traits\EnumValues;
use App\Traits\EnumOptions;

enum SizeDongPhuc: string
{
    use EnumValues, EnumOptions;

    case SIZE_5 = '5';
    case SIZE_7 = '7';
    case SIZE_9 = '9';
    case SIZE_11 = '11';
    case SIZE_13 = '13';
    case SIZE_S = 'S';
    case SIZE_M = 'M';

    public function getLabel(): string
    {
        return "Size {$this->value}";
    }
}