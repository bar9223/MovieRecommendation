<?php

declare(strict_types=1);

namespace App\Utils\Docs;

use Attribute;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final class DocsResponseEntity extends OA\Response
{
    public function __construct(string $class, ?string $description = 'Object data', int $response = 200)
    {
        $content = new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'boolean'),
                new OA\Property(property: 'data', ref: new Model(type: $class, groups: ['API', 'DOCS']), type: 'object'),
            ],
            type: 'object',
        );
        parent::__construct(response: $response, description: $description, content: $content);
    }
}
