<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Message\ErrorAlertMessage;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final class LoggerService
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly MessageBusInterface $bus
    ) {
    }

    public function emergency(string $message, array $context = array(), bool $sendAlert = false): void
    {
        $this->logger->emergency($message, $context);

        if ($sendAlert) {
            $this->sendAlertMessage($message);
        }
    }

    public function alert(string $message, array $context = array(), bool $sendAlert = false): void
    {
        $this->logger->alert($message, $context);

        if ($sendAlert) {
            $this->sendAlertMessage($message);
        }
    }

    public function critical(string $message, array $context = array(), bool $sendAlert = false): void
    {
        $this->logger->critical($message, $context);

        if ($sendAlert) {
            $this->sendAlertMessage($message);
        }
    }

    public function error(string $message, array $context = array(), bool $sendAlert = false): void
    {
        $this->logger->error($message, $context);

        if ($sendAlert) {
            $this->sendAlertMessage($message);
        }
    }

    public function warning(string $message, array $context = array()): void
    {
        $this->logger->warning($message, $context);
    }

    public function notice(string $message, array $context = array()): void
    {
        $this->logger->notice($message, $context);
    }

    public function info(string $message, array $context = array()): void
    {
        $this->logger->info($message, $context);
    }

    public function debug(string $message, array $context = array()): void
    {
        $this->logger->debug($message, $context);
    }

    public function log(mixed $level, string $message, array $context = array()): void
    {
        $this->logger->log($level, $message, $context);
    }

    private function sendAlertMessage(string $message): void
    {

        try {
            $this->bus->dispatch(new ErrorAlertMessage($message));
        } catch (Throwable) {
        }
    }
}
