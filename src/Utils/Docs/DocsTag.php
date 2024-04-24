<?php

declare(strict_types=1);

namespace App\Utils\Docs;

use OpenApi\Attributes as OA;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::IS_REPEATABLE)]
final class DocsTag extends OA\Tag
{
}
