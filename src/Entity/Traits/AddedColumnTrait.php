<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;
use Symfony\Component\Serializer\Annotation\Groups;

trait AddedColumnTrait
{
    #[ORM\Column(name: 'added', type: Types::DATETIME_MUTABLE, nullable: true, options: ['default' => 'CURRENT_TIMESTAMP'])]
    #[Groups(groups: ['WS', 'API'])]
    #[Timestampable(on: 'create')]
    private ?DateTime $added = null;

    public function setAdded(?DateTime $added): self
    {
        $this->added = $added;

        return $this;
    }

    public function getAdded(): ?DateTime
    {
        return $this->added;
    }
}
