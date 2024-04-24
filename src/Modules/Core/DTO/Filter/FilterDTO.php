<?php

declare(strict_types=1);

namespace App\Modules\Core\DTO\Filter;

class FilterDTO
{
    public function __construct(
        private string $propertyName,
        private string $value,
        private string $operation
    ) {
    }

    public function getPropertyName(): string
    {
        return $this->propertyName;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getOperation(): string
    {
        return $this->operation;
    }
}
