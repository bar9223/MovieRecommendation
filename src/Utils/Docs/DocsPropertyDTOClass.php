<?php

declare(strict_types=1);

namespace App\Utils\Docs;

use Attribute;
use LogicException;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER | Attribute::TARGET_CLASS_CONSTANT)]
final class DocsPropertyDTOClass extends OA\Property
{
    public function __construct(string $dtoClass, bool $multipleItems = false, bool $nullable = false)
    {
        if (!class_exists($dtoClass)) {
            throw new LogicException('Invalid dto class provided');
        }

        if ($multipleItems) {
            parent::__construct(
                type: 'array',
                items: new OA\Items(
                    ref: new Model(type: $dtoClass, groups: ['DOCS']),
                    type: 'schema',
                    nullable: $nullable
                )
            );
        } else {
            parent::__construct(ref: new Model(type: $dtoClass, groups: ['DOCS']), type: 'schema', nullable: $nullable);
        }
    }
}
