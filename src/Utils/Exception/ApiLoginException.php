<?php

declare(strict_types=1);

namespace App\Utils\Exception;

use Symfony\Component\HttpFoundation\Response;
use Exception;

final class ApiLoginException extends Exception implements ExceptionMessagesInterface
{
    use ApiExceptionTrait;

    public function __construct(string $errorCode, string $message, ?array $messageData = null)
    {
        $this->errorCode = $errorCode;
        $this->messageData = $messageData;
        parent::__construct($message);
    }

    public function getHttpCode(): int
    {
        return Response::HTTP_UNAUTHORIZED;
    }
}
