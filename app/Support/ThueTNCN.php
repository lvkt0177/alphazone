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
            $tntt <= 10_000_000 => $tntt * 0.05,
            $tntt <= 30_000_000 => $tntt * 0.10 - 500_000,
            $tntt <= 60_000_000 => $tntt * 0.20 - 3_500_000,
            $tntt <= 100_000_000 => $tntt * 0.30 - 9_500_000,
            default => $tntt * 0.35 - 14_500_000,
        };

        return (int) round(max(0, $thue));
    }
}