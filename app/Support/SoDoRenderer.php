<?php

namespace App\Support;

class SoDoRenderer
{
    public static function render(?array $soDo, array $mauSac): string
    {
        if (! $soDo) {
            return '';
        }

        $html = '';

        foreach ($soDo['objects'] ?? [] as $obj) {
            $html .= self::veVatDung($obj, $mauSac);
        }

        foreach ($soDo['arrows'] ?? [] as $arrow) {
            $html .= self::veMuiTen($arrow);
        }

        return $html;
    }

    private static function mau(?string $color, array $mauSac): string
    {
        return match ($color) {
            'blue' => $mauSac['blue'] ?? '#0ffdfd',
            'green' => $mauSac['green'] ?? '#0af15f',
            'yellow' => $mauSac['yellow'] ?? '#fffc32',
            'orange' => $mauSac['orange'] ?? '#ffcf66',
            default => '#111111',
        };
    }

    private static function veVatDung(array $obj, array $mauSac): string
    {
        $x = $obj['x'] ?? 0;
        $y = $obj['y'] ?? 0;
        $type = $obj['type'] ?? '';
        $mauFill = self::mau($obj['color'] ?? null, $mauSac);

        $noiDung = match ($type) {
            'nam' => '<circle r="16" fill="'.$mauFill.'"></circle><circle r="5" fill="#111111"></circle>',
            'con' => '<svg x="-25" y="-25" width="50" height="50" viewBox="0 0 16 16">'
                .'<path fill="'.$mauFill.'" d="M7.03 1.88c.252-1.01 1.688-1.01 1.94 0l2.905 11.62H14a.5.5 0 0 1 0 1H2a.5.5 0 0 1 0-1h2.125z"></path>'
                .'</svg>',
            'bong' => '<svg x="-16" y="-16" width="32" height="32" viewBox="0 0 64 64">'
                .'<circle cx="32" cy="32" r="29.3" fill="#ffffff"></circle>'
                .'<path fill="#4a4e51" d="M61.9 32c0-.7.2-10.9-5.8-17.5c-.3-.6-1.5-3-5.6-5.9C47.8 6.5 45 5 44.7 4.8S39.4 2 33.4 2c-.5 0-.9 0-1.4.1c-4.6-.1-8.8 1.1-11.9 2.5c-3.2 1.4-5.3 2.8-5.5 3c-3.4 1.9-9.9 9.5-10.4 13.6c-2.1 2.6-3.8 14.5 0 21.7c2.7 10 12.7 15 13.5 15.4c.5.3 5.9 3.7 12.6 3.7h.9c.6.1 1.1.1 1.7.1c7.2 0 18-5.1 20.2-9.1c6.2-4.6 9.4-16.2 8.8-21M17.8 47.1c-2.9-4.6-4.5-10.7-4.9-12.1c.9-1.4 5.4-8 7.9-10c1.4.3 7.5 1.4 13.2 2.4c.7 1.9 3.9 10 4.8 13.2c-1 1.2-4.9 5.7-8.7 9.2c-4.1.1-11-2.3-12.3-2.7m36-32.5c0 .4-.1 2-.9 3.9c-1.5-.8-5.3-2.4-10.6-2.7c-.8-1.2-3.8-5.3-8.5-8.1c.6-1.3 1.5-2.8 2.1-3.3c.2 0 .4-.1.8-.1c2.5 0 6.9 1.7 7.3 1.8c.4.2 8.3 4.4 9.8 8.5M11.8 34c-3.4-.6-5.5-1.6-6.1-2c-1.3-4.6-.2-9.6-.1-10.3c1.3-2.2 4.8-8 7.2-9.1c2.4-.5 5.5.1 6.7.4c-.1 1.6-.3 6.1.3 10.9c-2.6 2.2-6.9 8.5-8 10.1M31.7 3.5c.8.1 1.9.2 2.7.5c-.8 1-1.6 2.5-1.9 3.3c-1.6.3-7.5 1.4-12.2 4.4c-.9-.2-3.8-.9-6.5-.7c.7-1.3 1.7-2.2 1.8-2.3c.3-.3 7.4-5.3 16.1-5.2m19.1 38.1c-1.2 0-5.7-.3-10.6-1.5c-.9-3.3-4.1-11.4-4.8-13.3c3.1-4.4 6.1-8.5 6.9-9.7c5.7.4 9.7 2.5 10.5 2.9c3.3 5.3 4 10.7 4.1 11.6c-1.8 5.5-5.2 9.2-6.1 10M3.7 28.5c.1 1.3.3 2.6.7 3.9c-.3.9-.6 1.8-.7 2.7c-.3-2.3-.3-4.6 0-6.6M18.5 57l-.4.6zc-2.5-1.2-4.4-4-5.2-5.1c1.5-1.5 3.4-2.9 4.1-3.4c1.6.6 8.3 2.8 12.6 2.8c.7 1 3.1 4 6 6.4c-1.8 1.8-4.4 2.6-4.9 2.8c-6.8.2-12.6-3.5-12.6-3.5m16.3 3.4c.9-.5 1.9-1.2 2.7-2.1c1.3-.2 6.9-1.1 11.9-4.8c.3 0 .9.1 1.5.1c-3.1 2.9-10.5 6.2-16.1 6.8M50.2 52c1.8-4.7 1.7-8.3 1.6-9.4c1-1 4.4-4.6 6.3-10.1c1 .2 1.7.4 2 .6c.1.4.3 1.3.2 2.7c-.8 5-3.4 12.6-8.1 15.9c-.5.3-1.3.4-2 .3"></path>'
                .'</svg>',
            'nguoi' => '<svg x="-30" y="-30" width="60" height="60" viewBox="0 0 24 24">'
                .'<path fill="'.$mauFill.'" d="M12 2a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2m-1.5 5h3a2 2 0 0 1 2 2v5.5H14V22h-4v-7.5H8.5V9a2 2 0 0 1 2-2"></path>'
                .'</svg>',
            'giaovien' => '<circle r="16" fill="#111111"></circle><text y="6" font-size="16" fill="#ffffff" text-anchor="middle">C</text>',
            'hotro' => '<circle r="16" fill="#111111"></circle><text y="6" font-size="16" fill="#ffffff" text-anchor="middle">A</text>',
            default => '',
        };

        return '<g transform="translate('.$x.','.$y.')">'.$noiDung.'</g>';
    }

    private static function veMuiTen(array $arrow): string
    {
        $type = $arrow['type'] ?? 'chuyen';
        $so = $arrow['so'] ?? '';
        $diem = $arrow['points'] ?? [];

        if (count($diem) < 2) {
            return '';
        }

        return $type === 'dan_bong'
            ? self::veMuiTenDanBong($diem, $so)
            : self::veMuiTenThang($diem, $type, $so);
    }

    private static function veMuiTenThang(array $diem, string $type, $so): string
    {
        $p1 = $diem[0];
        $p2 = $diem[count($diem) - 1];
        $midX = ($p1[0] + $p2[0]) / 2;
        $midY = ($p1[1] + $p2[1]) / 2;

        [$ux, $uy, $px, $py] = self::huongVaVuongGoc($p1, $p2);

        $dai = 35;
        $rong = 15;
        $goc1 = [$p2[0] - $ux * $dai + $px * $rong, $p2[1] - $uy * $dai + $py * $rong];
        $goc2 = [$p2[0] - $ux * $dai - $px * $rong, $p2[1] - $uy * $dai - $py * $rong];
        $cuoiThan = [$p2[0] - $ux * $dai, $p2[1] - $uy * $dai];

        $dauMuiTen = '<polygon points="'.$p2[0].','.$p2[1].' '.$goc1[0].','.$goc1[1].' '.$goc2[0].','.$goc2[1].'" fill="#000000"></polygon>';

        if ($type === 'sut') {
            $ox = $px * 4;
            $oy = $py * 4;
            $than = '<line x1="'.($p1[0] + $ox).'" y1="'.($p1[1] + $oy).'" x2="'.($cuoiThan[0] + $ox).'" y2="'.($cuoiThan[1] + $oy).'" stroke="#000000" stroke-width="3"></line>'
                .'<line x1="'.($p1[0] - $ox).'" y1="'.($p1[1] - $oy).'" x2="'.($cuoiThan[0] - $ox).'" y2="'.($cuoiThan[1] - $oy).'" stroke="#000000" stroke-width="3"></line>';
        } else {
            $than = '<line x1="'.$p1[0].'" y1="'.$p1[1].'" x2="'.$cuoiThan[0].'" y2="'.$cuoiThan[1].'" stroke="#000000" stroke-width="3"></line>';
        }

        $nhanSo = '<circle cx="'.$midX.'" cy="'.$midY.'" r="11" fill="#ffffff" stroke="#000000" stroke-width="1.5"></circle>'
            .'<text x="'.$midX.'" y="'.($midY + 4).'" font-size="12" font-weight="700" fill="#000000" text-anchor="middle">'.$so.'</text>';

        return '<g>'.$than.$dauMuiTen.$nhanSo.'</g>';
    }

    private static function duongCongCatmullRom(array $diem): string
    {
        if (count($diem) < 2) {
            return '';
        }

        $d = 'M '.$diem[0][0].' '.$diem[0][1].' ';
        $n = count($diem);

        for ($i = 0; $i < $n - 1; $i++) {
            $p0 = $diem[$i - 1] ?? $diem[$i];
            $p1 = $diem[$i];
            $p2 = $diem[$i + 1];
            $p3 = $diem[$i + 2] ?? $p2;

            $cp1x = $p1[0] + ($p2[0] - $p0[0]) / 6;
            $cp1y = $p1[1] + ($p2[1] - $p0[1]) / 6;
            $cp2x = $p2[0] - ($p3[0] - $p1[0]) / 6;
            $cp2y = $p2[1] - ($p3[1] - $p1[1]) / 6;

            $d .= 'C '.$cp1x.' '.$cp1y.' '.$cp2x.' '.$cp2y.' '.$p2[0].' '.$p2[1].' ';
        }

        return $d;
    }

    private static function veMuiTenDanBong(array $diem, $so): string
    {
        $duongCong = self::duongCongCatmullRom($diem);

        $n = count($diem);
        $pTruocCuoi = $diem[$n - 2];
        $pCuoi = $diem[$n - 1];

        [$ux, $uy, $px, $py] = self::huongVaVuongGoc($pTruocCuoi, $pCuoi);

        $dai = 35;
        $rong = 15;
        $goc1 = [$pCuoi[0] - $ux * $dai + $px * $rong, $pCuoi[1] - $uy * $dai + $py * $rong];
        $goc2 = [$pCuoi[0] - $ux * $dai - $px * $rong, $pCuoi[1] - $uy * $dai - $py * $rong];
        $dauMuiTen = '<polygon points="'.$pCuoi[0].','.$pCuoi[1].' '.$goc1[0].','.$goc1[1].' '.$goc2[0].','.$goc2[1].'" fill="#000000"></polygon>';

        $duongMarkup = '<path d="'.$duongCong.'" fill="none" stroke="#000000" stroke-width="3" stroke-dasharray="10,7" stroke-linecap="round"></path>';

        $diemGiua = $diem[intdiv($n, 2)];
        $nhanSo = '<circle cx="'.$diemGiua[0].'" cy="'.$diemGiua[1].'" r="11" fill="#ffffff" stroke="#000000" stroke-width="1.5"></circle>'
            .'<text x="'.$diemGiua[0].'" y="'.($diemGiua[1] + 4).'" font-size="12" font-weight="700" fill="#000000" text-anchor="middle">'.$so.'</text>';

        return '<g>'.$duongMarkup.$dauMuiTen.$nhanSo.'</g>';
    }

    private static function huongVaVuongGoc(array $tu, array $den): array
    {
        $dx = $den[0] - $tu[0];
        $dy = $den[1] - $tu[1];
        $len = sqrt($dx * $dx + $dy * $dy) ?: 1;
        $ux = $dx / $len;
        $uy = $dy / $len;

        return [$ux, $uy, -$uy, $ux];
    }
}