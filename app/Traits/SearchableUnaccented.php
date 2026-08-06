<?php

namespace App\Traits;

trait SearchableUnaccented
{
    public function scopeWhereUnaccentedLike($query, string $column, string $term)
    {
        $expr = static::unaccentSqlExpression($column);
        $needle = '%'.remove_vietnamese_accents($term).'%';

        return $query->whereRaw("{$expr} LIKE ?", [$needle]);
    }

    public function scopeOrWhereUnaccentedLike($query, string $column, string $term)
    {
        $expr = static::unaccentSqlExpression($column);
        $needle = '%'.remove_vietnamese_accents($term).'%';

        return $query->orWhereRaw("{$expr} LIKE ?", [$needle]);
    }

    protected static function unaccentSqlExpression(string $column): string
    {
        $mapThuong = [
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

        $map = $mapThuong;
        foreach ($mapThuong as $co_dau => $khong_dau) {
            $map[mb_strtoupper($co_dau)] = $khong_dau;
        }

        $expr = "LOWER({$column})";
        foreach ($map as $accented => $plain) {
            $expr = "REPLACE({$expr}, '{$accented}', '{$plain}')";
        }

        return $expr;
    }
}