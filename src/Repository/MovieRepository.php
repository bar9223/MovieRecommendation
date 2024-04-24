<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    public function getRandomMovies(): array
    {
        $ids = $this->createQueryBuilder('m')
            ->select('m.id')
            ->where('m.deleted IS NULL')
            ->getQuery()
            ->getResult();

        shuffle($ids);
        $randomIds = array_slice($ids, 0, 3);

        return $this->createQueryBuilder('m')
            ->where('m.id IN (:ids)')
            ->setParameter('ids', $randomIds)
            ->getQuery()
            ->getResult();
    }

    public function getMoviesStartingWithWAndEvenLength(): array
    {
        $movies = $this->createQueryBuilder('m')
            ->where('m.name LIKE :prefix')
            ->andWhere('m.deleted IS NULL')
            ->setParameter('prefix', 'W%')
            ->getQuery()
            ->getResult();

        return array_filter($movies, function ($movie) {
            return strlen($movie->getName()) % 2 === 0;
        });
    }

    public function getMoviesWithMoreThanOneWord(): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.name LIKE :pattern')
            ->andWhere('m.deleted IS NULL')
            ->setParameter('pattern', '% %')
            ->getQuery()
            ->getResult();
    }
}
