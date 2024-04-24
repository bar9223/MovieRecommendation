<?php

declare(strict_types=1);

namespace App\Utils\Exception;

interface ExceptionMessagesInterface
{
    public function getMessages(): array;

    public function getHttpCode(): int;
}
