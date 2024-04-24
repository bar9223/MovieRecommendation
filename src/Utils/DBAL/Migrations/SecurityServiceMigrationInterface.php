<?php

declare(strict_types=1);

namespace App\Utils\DBAL\Migrations;

use App\Service\SecurityService;

interface SecurityServiceMigrationInterface
{
    public function setSecurityService(?SecurityService $securityService): self;
}
