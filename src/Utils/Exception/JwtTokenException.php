<?php

declare(strict_types=1);

namespace App\Utils\Exception;

use Symfony\Component\HttpFoundation\Response;
use Exception;

final class JwtTokenException extends Exception implements ExceptionMessagesInterface
{
    public function __construct(private readonly string $errorCode, string $message)
    {
        parent::__construct($message);
    }

    public function getMessages(): array
    {
        return [
            [
                'code' => $this->errorCode,
                'message' => $this->message,
            ],
        ];
    }

    public function getHttpCode(): int
    {
        return Response::HTTP_UNAUTHORIZED;
    }
}
