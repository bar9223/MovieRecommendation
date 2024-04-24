<?php

declare(strict_types=1);

namespace App\Utils\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

final class ApiResponse extends JsonResponse
{
    public function __construct(string $data, int $httpCode)
    {
        parent::__construct($data, $httpCode, [], true);
    }
}
