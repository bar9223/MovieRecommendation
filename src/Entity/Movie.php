<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\AddedColumnTrait;
use App\Entity\Traits\EditedColumnTrait;
use App\Entity\Traits\SoftDeleteTrait;
use App\Repository\MovieRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Table(name: 'Movie')]
#[ORM\Entity(repositoryClass: MovieRepository::class)]
class Movie
{
    use AddedColumnTrait;
    use EditedColumnTrait;
    use SoftDeleteTrait;

    #[ORM\Column(name: 'id', type: Types::INTEGER, nullable: false, options: ['unsigned' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[Groups(groups: ['API'])]
    private int $id;

    #[ORM\Column(type: Types::STRING, length: 64, nullable: false)]
    #[Groups(groups: ['API'])]
    private string $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
