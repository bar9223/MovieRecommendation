<?php

declare(strict_types=1);

namespace App\Utils\DBAL\Migrations;

use App\Service\EntityService;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\Migrations\Version\MigrationFactory;

class MigrationFactoryDecorator implements MigrationFactory
{
    public function __construct(
        private readonly MigrationFactory $migrationFactory,
        private readonly EntityService $entityService,
    ) {
    }

    public function createVersion(string $migrationClassName): AbstractMigration
    {
        $migration = $this->migrationFactory->createVersion($migrationClassName);

        if ($migration instanceof EntityServiceMigrationInterface) {
            $migration->setEntityService($this->entityService);
        }

        return $migration;
    }
}
