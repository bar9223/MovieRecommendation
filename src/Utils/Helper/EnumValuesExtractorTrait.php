<?php

declare(strict_types=1);

namespace App\Utils\Helper;

trait EnumValuesExtractorTrait
{
    public static function values(): array
    {
        return array_column(static::cases(), 'value');
    }
}
