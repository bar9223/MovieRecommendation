<?php

declare(strict_types=1);

namespace App\Utils\Exception;

use Symfony\Component\HttpFoundation\Response;
use Exception;

final class ApiForbiddenException extends Exception implements ExceptionMessagesInterface
{
    use ApiExceptionTrait;

    public function __construct(string $message = 'Access forbidden', ?string $errorCode = null, ?array $messageData = null)
    {
        $this->errorCode = $errorCode ?: $this->createErrorCode($message);
        $this->messageData = $messageData;
        parent::__construct($message);
    }

    public function getHttpCode(): int
    {
        return Response::HTTP_FORBIDDEN;
    }
}
