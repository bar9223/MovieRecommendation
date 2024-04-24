<?php

declare(strict_types=1);

namespace App\Component\Controller;

use App\Service\EntityService;
use App\Service\LoggerService;
use App\Utils\Response\ApiResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Messenger\Exception\LogicException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

abstract class AbstractApiController extends AbstractController implements ControllerInterface
{
    use ApiResponseTrait;

    protected Request $request;
    protected ?array $tokenData = null;

    public function __construct(
        RequestStack $requestStack,
        protected ParameterBagInterface $params,
        protected EntityService $entityService,
        protected EventDispatcherInterface $dispatcher,
        protected LoggerService $loggerService,
        protected MessageBusInterface $messageBus,
    ) {
        $this->request = $requestStack->getCurrentRequest();
    }

    protected function handleMessage(object $message): mixed
    {
        if (!$this->messageBus instanceof MessageBusInterface) {
            throw new LogicException(sprintf(
                'You must provide a "%s" instance in the "%s::$messageBus" property, "%s" given.',
                MessageBusInterface::class,
                static::class,
                get_debug_type($this->messageBus)
            ));
        }

        $envelope = $this->messageBus->dispatch($message);
        /** @var HandledStamp[] $handledStamps */
        $handledStamps = $envelope->all(HandledStamp::class);

        if (!$handledStamps) {
            throw new LogicException(sprintf(
                'Message of type "%s" was handled zero times. Exactly one handler is expected when using "%s::%s()".',
                get_debug_type($envelope->getMessage()),
                static::class,
                __FUNCTION__
            ));
        }

        if (count($handledStamps) > 1) {
            $handlers = implode(', ', array_map(function (HandledStamp $stamp): string {
                return sprintf('"%s"', $stamp->getHandlerName());
            }, $handledStamps));

            throw new LogicException(sprintf(
                'Message of type "%s" was handled multiple times. Only one handler is expected when using "%s::%s()", got %d: %s.',
                get_debug_type($envelope->getMessage()),
                static::class,
                __FUNCTION__,
                \count($handledStamps),
                $handlers
            ));
        }

        return $handledStamps[0]->getResult();
    }
}
