<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Gedmo\Mapping\Annotation\Timestampable;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

trait EditedColumnTrait
{
    #[ORM\Column(name: 'edited', type: Types::DATETIME_MUTABLE, nullable: true, options: ['default' => null])]
    #[Groups(groups: ['WS', 'API'])]
    #[Timestampable(on: 'update')]
    private ?DateTime $edited = null;

    public function setEdited(?DateTime $edited): self
    {
        $this->edited = $edited;

        return $this;
    }

    public function getEdited(): ?DateTime
    {
        return $this->edited;
    }
}
