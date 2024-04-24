<?php

declare(strict_types=1);

namespace App\Tests\Api;

use JsonException;
use MongoDB\Driver\Exception\RuntimeException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class ApiWebTestCase extends WebTestCase
{
    public const API_FIREWAL_CONTEXT = 'api';
    public const WEB = 'WEB';
    protected const GET = 'GET';
    private const CLIENT_DATA = [
        'HTTP_HOST' => 'web',
        'HTTP_USER_AGENT' => 'ApiTesting/1.0',
    ];
    private KernelBrowser $client;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient([], self::CLIENT_DATA);
    }

    public function decodeContent(Response $response): ?array
    {
        try {
            return json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            return null;
        }
    }

    public function getRequestBuilder(): RequestBuilder
    {
        return new RequestBuilder();
    }

    public function makeRequest(
        RequestBuilder $builder,
    ): ApiResponseDTO {
        $response = $this->makeDeprecatedRequest($builder);
        $content = $this->decodeContent($response);

        return new ApiResponseDTO(
            $response->getStatusCode(),
            $content['status'] ?? null,
            $content['data'] ?? null,
            $response
        );
    }

    public function makeDeprecatedRequest(
        RequestBuilder $builder,
    ): Response {
        $parameters = [];
        $files = [];
        $server = [];
        $content = null;

        if (!empty($builder->body)) {
            match ($builder->method) {
                self::GET => $parameters = $builder->body,
                default => throw new RuntimeException('Missing method')
            };
        }

        if (!empty($builder->additionalHeaders)) {
            $server = $this->addCustomHeadersToServer($builder->additionalHeaders, $server);
        }

        // php auth
        $this->client->request(
            $builder->method,
            $builder->uri,
            $parameters,
            $files,
            $server,
            $content
        );

        return $this->client->getResponse();
    }

    protected function assertResponseStatus(ApiResponseDTO $response): void
    {
        $this->assertTrue($response->status);
        $this->assertEquals(200, $response->statusCode);
    }

    private function addCustomHeadersToServer(array $headers, array $server): array
    {
        foreach ($headers as $name => $value) {
            $name = strtoupper(str_replace('-', '_', $name));
            $server[sprintf('HTTP_%s', $name)] = $value;
        }

        return $server;
    }
}
