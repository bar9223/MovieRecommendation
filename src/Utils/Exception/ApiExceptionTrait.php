<?php

declare(strict_types=1);

namespace App\Utils\Exception;

trait ApiExceptionTrait
{
    private readonly string $errorCode;
    private readonly ?array $messageData;

    public function getMessages(): array
    {
        return [
            [
                'code' => $this->errorCode,
                'message' => $this->message,
                'messageData' => $this->messageData ?? null,
            ],
        ];
    }

    private function createErrorCode(string $message): string
    {
        $string = md5($message);
        return
            substr($string, 0, 8)
            . '-' . substr($string, 8, 4)
            . '-' . substr($string, 12, 4)
            . '-' . substr($string, 16, 4)
            . '-' . substr($string, 20)
        ;
    }
}
