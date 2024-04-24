<?php

declare(strict_types=1);

namespace App\Modules\Core\DTO\Filter;

class FilterInfoDTO
{
    public function __construct(private string $operation)
    {
    }

    public function getOperation(): string
    {
        return $this->operation;
    }
}
