<?php

declare(strict_types=1);

namespace App\Utils\Provider;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final class AppDataProvider implements AppDataProviderInterface
{
    /**
     * AppDataProvider constructor.
     */
    public function __construct(private readonly ParameterBagInterface $params)
    {
    }

    public function getSelfUrl(): string
    {
        $config = (array) ($this->params->get('app.urls') ?? []);

        return (string) ($config['self'] ?? '');
    }

    public function getFrontUrl(): string
    {
        $config = (array) ($this->params->get('app.urls') ?? []);

        return (string) ($config['front'] ?? '');
    }
}
