<?php

declare(strict_types=1);

namespace App\Utils\Docs;

use OpenApi\Attributes as OA;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::TARGET_PROPERTY | \Attribute::TARGET_PARAMETER | \Attribute::IS_REPEATABLE)]
final class DocsRequestQueryParam extends OA\Parameter
{
    public function __construct(string $name, ?string $description = null)
    {
        parent::__construct(description: $description, name: $name, in: 'query');
    }
}
