<?php

declare(strict_types=1);

namespace App\Tests\Api\Controller;

use App\Tests\Api\ApiWebTestCase;
use App\Utils\DBAL\Types\MovieFilterType;
use Symfony\Component\HttpFoundation\Response;

final class MovieControllerTest extends ApiWebTestCase
{
    public function testRandomMoviesGet(): void
    {
        $request = $this->getRequestBuilder()
            ->isLogged()
            ->isWebUser()
            ->setMethod(self::GET)
            ->setUri('/api/movies?filter=' . MovieFilterType::RANDOM);
        $response = $this->makeRequest($request);

        self::assertTrue($response->status);
        self::assertSame(Response::HTTP_OK, $response->statusCode);
        self::assertIsArray($response->data);
        self::assertCount(3, $response->data);
    }

    public function testMoviesStartingWithWAndEvenLengthGet(): void
    {
        $request = $this->getRequestBuilder()
            ->isLogged()
            ->isWebUser()
            ->setMethod(self::GET)
            ->setUri('/api/movies?filter=' . MovieFilterType::W_AND_EVEN);
        $response = $this->makeRequest($request);

        self::assertTrue($response->status);
        self::assertSame(Response::HTTP_OK, $response->statusCode);
        self::assertIsArray($response->data);

        foreach ($response->data as $movie) {
            self::assertTrue(str_starts_with($movie['name'], 'W'));
            self::assertEquals(0, strlen($movie['name']) % 2);
        }
    }

    public function testMoviesWithMoreThanOneWordGet(): void
    {
        $request = $this->getRequestBuilder()
            ->isLogged()
            ->isWebUser()
            ->setMethod(self::GET)
            ->setUri('/api/movies?filter=' . MovieFilterType::MORE_WORDS);
        $response = $this->makeRequest($request);

        self::assertTrue($response->status);
        self::assertSame(Response::HTTP_OK, $response->statusCode);
        self::assertIsArray($response->data);

        foreach ($response->data as $movie) {
            self::assertTrue(count(explode(' ', $movie['name'])) > 1);
        }
    }
}
