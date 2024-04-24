<?php

declare(strict_types=1);

namespace App\Utils\Docs;

final class DocsResponsePropertyDTO
{
    public function __construct(
        public readonly string $property,
        public readonly ?string $type = null,
        public readonly ?string $class = null,
        public readonly bool $isArray = false,
    ) {
    }
}
