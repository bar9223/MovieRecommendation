<?php

declare(strict_types=1);

namespace App\Utils\Exception;

use Throwable;
use Exception;

final class CommandException extends Exception
{
    public function __construct(
        string $message = 'Something went wrong during command execution.',
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
