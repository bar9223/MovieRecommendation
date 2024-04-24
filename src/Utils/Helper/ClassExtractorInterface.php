<?php

namespace App\Utils\Helper;

interface ClassExtractorInterface
{
    public function getDTOClass(string $className): object;

    public function getEntityClass(string $className): object;
}
