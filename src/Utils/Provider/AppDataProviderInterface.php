<?php

declare(strict_types=1);

namespace App\Utils\Provider;

interface AppDataProviderInterface
{
    public function getSelfUrl(): string;

    public function getFrontUrl(): string;
}
