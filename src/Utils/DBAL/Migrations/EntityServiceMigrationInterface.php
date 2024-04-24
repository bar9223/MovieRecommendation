<?php

declare(strict_types=1);

namespace App\Utils\DBAL\Migrations;

use App\Service\EntityService;

interface EntityServiceMigrationInterface
{
    public function setEntityService(?EntityService $entityService): self;
}
