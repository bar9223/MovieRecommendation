<?php

declare(strict_types=1);

namespace App\Utils\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;

final class ApiTooManyRequestsException extends Exception implements ExceptionMessagesInterface
{
    use ApiExceptionTrait;

    public function __construct(string $message = 'Too many requests', ?string $errorCode = null, ?array $messageData = null)
    {
        $this->errorCode = $errorCode ?: $this->createErrorCode($message);
        $this->messageData = $messageData;
        parent::__construct($message);
    }

    public function getHttpCode(): int
    {
        return Response::HTTP_TOO_MANY_REQUESTS;
    }
}
