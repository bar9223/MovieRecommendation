<?php

declare(strict_types=1);

namespace App\Utils\DTO;

abstract class AbstractResponseDTO
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
