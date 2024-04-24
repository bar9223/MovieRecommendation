<?php

declare(strict_types=1);

namespace App\Modules\Core\App\Api\Query\Movie\GetMovies;

use Symfony\Component\HttpFoundation\Request;

final class GetMoviesQuery
{
    public function __construct(
        public readonly Request $request
    ) {
    }
}
