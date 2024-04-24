<?php

declare(strict_types=1);

namespace App\Utils\Helper;

class ClassExtractor implements ClassExtractorInterface
{
    public function getDTOClass(string $className): object
    {
        $fullObjectName = 'App\\DTO\\Entity\\' . $className;

        return new $fullObjectName();
    }

    public function getEntityClass(string $className): object
    {
        $fullObjectName = 'App\\Entity\\' . $className;

        return new $fullObjectName();
    }
}
