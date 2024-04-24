<?php

declare(strict_types=1);

namespace App\Utils\Docs;

use OpenApi\Attributes as OA;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
final class DocsResponseNull extends OA\Response
{
    public function __construct(?string $description = 'Nullable data result', int $response = 200)
    {
        $content = new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'boolean'),
                new OA\Property(property: 'data', type: 'null', nullable: true),
            ],
            type: 'object',
        );
        parent::__construct(response: $response, description: $description, content: $content);
    }
}
