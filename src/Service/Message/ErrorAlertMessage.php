<?php

declare(strict_types=1);

namespace App\Service\Message;

use App\Component\Messenger\AbstractAsyncMessage;

final class ErrorAlertMessage extends AbstractAsyncMessage
{
    public function __construct(
        private readonly string $message
    ) {
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
