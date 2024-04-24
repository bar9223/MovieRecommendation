<?php

declare(strict_types=1);

namespace App\Utils\Docs;

use Attribute;
use LogicException;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::TARGET_PARAMETER)]
final class DocsRequestCustomBody extends OA\RequestBody
{
    public function __construct(?string $description, DocsResponsePropertyDTO ...$properties)
    {
        $preparedProperties = [];
        foreach ($properties as $property) {
            if (!$property instanceof DocsResponsePropertyDTO) {
                throw new LogicException('Invalid property provided');
            }
            if ($property->class) {
                if (!class_exists($property->class)) {
                    throw new LogicException('Class not exists');
                }

                if ($property->isArray) {
                    $preparedProperty = new OA\Property(
                        property: $property->property,
                        type: 'array',
                        items: new OA\Items(ref: new Model(type: $property->class, groups: ['API', 'DOCS']))
                    );
                } else {
                    $preparedProperty = new OA\Property(
                        property: $property->property,
                        ref: new Model(type: $property->class, groups: ['API', 'DOCS']),
                        type: 'object'
                    );
                }
            } else {
                $preparedProperty = new OA\Property(
                    property: $property->property,
                    type: $property->type
                );
            }
            $preparedProperties[] = $preparedProperty;
        }
        $content = new OA\JsonContent(
            properties: $preparedProperties,
            type: 'object',
        );
        parent::__construct(description: $description, content: $content);
    }
}
