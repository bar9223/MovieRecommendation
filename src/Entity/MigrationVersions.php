<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MigrationVersionsRepository;

#[ORM\Table(name: 'MigrationVersions')]
#[ORM\Entity(repositoryClass: MigrationVersionsRepository::class)]
class MigrationVersions
{
    #[ORM\Column(name: 'version', type: Types::STRING, length: 125, nullable: false)]
    #[ORM\Id]
    private ?string $version = null;

    #[ORM\Column(name: 'executedAt', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTime $executedAt = null;

    #[ORM\Column(name: 'executionTime', type: Types::INTEGER, nullable: true)]
    private ?int $executionTime = null;

    public function getVersion(): ?string
    {
        return $this->version;
    }
    public function getExecutedAt(): ?DateTime
    {
        return $this->executedAt;
    }
    public function setExecutedAt(DateTime $executedAt): self
    {
        $this->executedAt = $executedAt;

        return $this;
    }

    public function getExecutionTime(): ?int
    {
        return $this->executionTime;
    }
    public function setExecutionTime(?int $executionTime): self
    {
        $this->executionTime = $executionTime;

        return $this;
    }
}
