<?php

namespace App\Traits;

trait EnumOptions
{
    /**
     * Helper trait using for returning options
     */
    public static function options(bool $isObject = false): array
    {
        $cases = static::cases();
        $options = [];
        foreach ($cases as $case) {
            $data  = [
                'value' => $case->value,
                'label' => method_exists($case, 'getLabel') ? $case->getLabel() : $case->name,
                'badge' => method_exists($case, 'getBadge') ? $case->getBadge() : 'primary',
            ];
            $options[] = $isObject ? (object) $data : $data;
        }

        return $options;
    }
}
