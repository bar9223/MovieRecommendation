<?php

declare(strict_types=1);

/*
 * Ems.WebApp.Api
 *
 * (c) 2022 Ejsak Gorup
 */

namespace App\Command;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use App\Service\EntityService;
use App\Service\LoggerService;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:add-movies-from-file',
)]
final class AddMoviesFromFileCommand extends Command
{
    private const MOVIES_NAMES = [
        'Pulp Fiction',
        'Incepcja',
        'Skazani na Shawshank',
        'Dwunastu gniewnych ludzi',
        'Ojciec chrzestny',
        'Django',
        'Matrix',
        'Leon zawodowiec',
        'Siedem',
        'Nietykalni',
        'Władca Pierścieni: Powrót króla',
        'Fight Club',
        'Forrest Gump',
        'Chłopaki nie płaczą',
        'Gladiator',
        'Człowiek z blizną',
        'Pianista',
        'Doktor Strange',
        'Szeregowiec Ryan',
        'Lot nad kukułczym gniazdem',
        'Wielki Gatsby',
        'Avengers: Wojna bez granic',
        'Życie jest piękne',
        'Pożegnanie z Afryką',
        'Szczęki',
        'Milczenie owiec',
        'Dzień świra',
        'Blade Runner',
        'Labirynt',
        'Król Lew',
        'La La Land',
        'Whiplash',
        'Wyspa tajemnic',
        'Django',
        'American Beauty',
        'Szósty zmysł',
        'Gwiezdne wojny: Nowa nadzieja',
        'Mroczny Rycerz',
        'Władca Pierścieni: Drużyna Pierścienia',
        'Harry Potter i Kamień Filozoficzny',
        'Green Mile',
        'Iniemamocni',
        'Shrek',
        'Mad Max: Na drodze gniewu',
        'Terminator 2: Dzień sądu',
        'Piraci z Karaibów: Klątwa Czarnej Perły',
        'Truman Show',
        'Skazany na bluesa',
        'Infiltracja',
        'Gran Torino',
        'Spotlight',
        'Mroczna wieża',
        'Rocky',
        'Casino Royale',
        'Drive',
        'Piękny umysł',
        'Władca Pierścieni: Dwie wieże',
        'Zielona mila',
        'Requiem dla snu',
        'Forest Gump',
        'Requiem dla snu',
        'Milczenie owiec',
        'Czarnobyl',
        'Breaking Bad',
        'Nędznicy',
        'Seksmisja',
        'Pachnidło',
        'Nagi instynkt',
        'Zjawa',
        'Igrzyska śmierci',
        'Kiler',
        'Siedem dusz',
        'Dzień świra',
        'Upadek',
        'Lśnienie',
        'Pan życia i śmierci',
        'Gladiator',
        'Granica',
        'Hobbit: Niezwykła podróż',
        'Pachnidło: Historia mordercy',
        'Wielki Gatsby',
        'Titanic',
        'Sin City',
        'Przeminęło z wiatrem',
        'Królowa śniegu',
    ];

    public function __construct(
        private readonly MovieRepository $movieRepository,
        private readonly EntityService $entityService,
        private readonly LoggerService $loggerService,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->output = $output;
            $this->loggerService->info('[AddMoviesFromFileCommand] Adding movies from file to DB.');
            $this->output->writeln('Start');
            $this->postMovies();
            $this->output->writeln('Done.');
        } catch (RuntimeException $e) {
            $this->loggerService->error(
                sprintf(
                    '[AddMoviesFromFileCommand] Adding movies failure. Exception message: %s',
                    $e->getMessage()
                )
            );

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    private function postMovies(): void
    {
        foreach (self::MOVIES_NAMES as $movieName) {
            if ($this->movieRepository->findOneBy(['name' => $movieName])) {
                continue;
            }

            $movie = new Movie();
            $movie->setName($movieName);

            $this->entityService->save($movie);

            $this->output->writeln('Added movie: ' . $movieName);
        }
    }
}
