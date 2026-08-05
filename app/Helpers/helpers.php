<?php

use Illuminate\Support\Facades\Route;

if (! function_exists('safe_route')) {
    function safe_route(string $name, mixed $parameters = [], bool $absolute = true): string
    {
        return Route::has($name) ? route($name, $parameters, $absolute) : '#';
    }
}

if (! function_exists('remove_vietnamese_accents')) {
    function remove_vietnamese_accents(string $str): string
    {
        $str = mb_strtolower($str);

        if (class_exists(\Normalizer::class)) {
            $normalized = \Normalizer::normalize($str, \Normalizer::FORM_D);
            if ($normalized !== false) {
                $str = preg_replace('/\p{Mn}/u', '', $normalized);
            }
        }

        static $map = null;

        if ($map === null) {
            $map = [
                'à' => 'a', 'á' => 'a', 'ạ' => 'a', 'ả' => 'a', 'ã' => 'a',
                'â' => 'a', 'ầ' => 'a', 'ấ' => 'a', 'ậ' => 'a', 'ẩ' => 'a', 'ẫ' => 'a',
                'ă' => 'a', 'ằ' => 'a', 'ắ' => 'a', 'ặ' => 'a', 'ẳ' => 'a', 'ẵ' => 'a',
                'è' => 'e', 'é' => 'e', 'ẹ' => 'e', 'ẻ' => 'e', 'ẽ' => 'e',
                'ê' => 'e', 'ề' => 'e', 'ế' => 'e', 'ệ' => 'e', 'ể' => 'e', 'ễ' => 'e',
                'ì' => 'i', 'í' => 'i', 'ị' => 'i', 'ỉ' => 'i', 'ĩ' => 'i',
                'ò' => 'o', 'ó' => 'o', 'ọ' => 'o', 'ỏ' => 'o', 'õ' => 'o',
                'ô' => 'o', 'ồ' => 'o', 'ố' => 'o', 'ộ' => 'o', 'ổ' => 'o', 'ỗ' => 'o',
                'ơ' => 'o', 'ờ' => 'o', 'ớ' => 'o', 'ợ' => 'o', 'ở' => 'o', 'ỡ' => 'o',
                'ù' => 'u', 'ú' => 'u', 'ụ' => 'u', 'ủ' => 'u', 'ũ' => 'u',
                'ư' => 'u', 'ừ' => 'u', 'ứ' => 'u', 'ự' => 'u', 'ử' => 'u', 'ữ' => 'u',
                'ỳ' => 'y', 'ý' => 'y', 'ỵ' => 'y', 'ỷ' => 'y', 'ỹ' => 'y',
                'đ' => 'd',
            ];
        }

        return strtr($str, $map);
    }
}

if (! function_exists('generate_username_from_name')) {
    function generate_username_from_name(string $hoTen): string
    {
        $base = str_replace(' ', '', remove_vietnamese_accents($hoTen));
        $username = $base;
        $i = 2;

        while (\App\Models\User::where('name', $username)->exists()) {
            $username = $base.$i;
            $i++;
        }

        return $username;
    }
}

if (! function_exists('hasQuyen')) {
    function hasQuyen(string $chucNangKey, string $hanhDong = 'xem'): bool
    {
        $user = auth()->user();

        return $user ? $user->hasQuyen($chucNangKey, $hanhDong) : false;
    }
}