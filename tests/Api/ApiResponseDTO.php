<?php

declare(strict_types=1);

namespace App\Tests\Api;

use Symfony\Component\HttpFoundation\Response;

final class ApiResponseDTO
{
    public function __construct(
        public readonly ?int $statusCode,
        public readonly ?bool $status,
        public readonly mixed $data,
        public readonly ?Response $response
    ) {
    }
}
