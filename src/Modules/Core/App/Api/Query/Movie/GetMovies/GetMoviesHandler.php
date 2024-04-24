<?php

declare(strict_types=1);

namespace App\Modules\Core\App\Api\Query\Movie\GetMovies;

use App\Repository\MovieRepository;
use App\Utils\DBAL\Types\MovieFilterType;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class GetMoviesHandler
{
    public function __construct(
        private readonly MovieRepository $movieRepository,
    ) {
    }

    public function __invoke(GetMoviesQuery $query): ?array
    {
        $filter = (string) $query->request->get('filter', '');
        $findBy = [
            'deleted' => null,
        ];

        return match ($filter) {
            MovieFilterType::RANDOM => $this->movieRepository->getRandomMovies(),
            MovieFilterType::W_AND_EVEN => $this->movieRepository->getMoviesStartingWithWAndEvenLength(),
            MovieFilterType::MORE_WORDS => $this->movieRepository->getMoviesWithMoreThanOneWord(),
            default => $this->movieRepository->findBy($findBy),
        };
    }
}
