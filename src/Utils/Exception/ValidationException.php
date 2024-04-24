<?php

declare(strict_types=1);

namespace App\Utils\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Exception;

final class ValidationException extends Exception implements ExceptionMessagesInterface
{
    public function __construct(private readonly ConstraintViolationListInterface $violations)
    {
        parent::__construct('Validation failed.');
    }

    public function getMessages(): array
    {
        $messages = [];
        /** @var ConstraintViolationInterface $violation */
        foreach ($this->violations as $violation) {
            $messages[] = [
                'code' => $violation->getCode(),
                'message' => $violation->getMessage(),
                'messageData' => [
                    'fieldName' => $violation->getPropertyPath()
                ]
            ];
        }

        return $messages;
    }

    public function getHttpCode(): int
    {
        return Response::HTTP_UNPROCESSABLE_ENTITY;
    }
}
