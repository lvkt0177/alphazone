<?php

namespace App\Support;

class ThueTNCN
{
    public static function tinh(int $tntt): int
    {
        if ($tntt <= 0) {
            return 0;
        }

        $thue = match (true) {
            $tntt <= 5_000_000   => $tntt * 0.05,
            $tntt <= 10_000_000  => $tntt * 0.10 - 250_000,
            $tntt <= 18_000_000  => $tntt * 0.15 - 750_000,
            $tntt <= 32_000_000  => $tntt * 0.20 - 1_650_000,
            $tntt <= 52_000_000  => $tntt * 0.25 - 3_250_000,
            $tntt <= 80_000_000  => $tntt * 0.30 - 5_850_000,
            default             => $tntt * 0.35 - 9_850_000,
        };

        return (int) round(max(0, $thue));
    }
}