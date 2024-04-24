<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\MigrationVersions;
use Doctrine\Persistence\ManagerRegistry;

class MigrationVersionsRepository extends AbstractAppRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MigrationVersions::class);
    }
}
