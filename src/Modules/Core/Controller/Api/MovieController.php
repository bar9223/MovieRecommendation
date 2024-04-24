<?php

declare(strict_types=1);

namespace App\Modules\Core\Controller\Api;

use App\Component\Controller\AbstractApiController;
use App\Entity\Movie;
use App\Modules\Core\App\Api\Query\Movie\GetMovies\GetMoviesQuery;
use App\Utils\Docs\DocsRequestQueryParam;
use App\Utils\Docs\DocsResponseEntities;
use App\Utils\Docs\DocsTag;
use App\Utils\Response\ApiResponse;
use OpenApi\Attributes\RequestBody;

#[DocsTag('Movie')]
final class MovieController extends AbstractApiController
{
    #[RequestBody()]
    #[DocsRequestQueryParam('filter')]
    #[DocsResponseEntities(
        Movie::class,
        description: 'Get list of movies with filters: random, w_and_even, more_words'
    )]
    public function getMovies(): ApiResponse
    {
        $query = new GetMoviesQuery($this->request);

        return $this->createApiResponse($this->handleMessage($query));
    }
}
