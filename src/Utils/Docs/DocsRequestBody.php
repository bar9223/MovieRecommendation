<?php

declare(strict_types=1);

namespace App\Utils\Docs;

use LogicException;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::TARGET_PARAMETER)]
final class DocsRequestBody extends OA\RequestBody
{
    public function __construct(?string $description, ?string $dtoClass = null)
    {
        var_dump($description);
        $content = null;
        if ($dtoClass) {
            if (!class_exists($dtoClass)) {
                throw new LogicException('Invalid dto class provided');
            }
            $content = new OA\JsonContent(
                ref: new Model(type: $dtoClass, groups: ['DOCS']),
                type: 'schema'
            );
        }
        parent::__construct(description: $description);
    }
}
