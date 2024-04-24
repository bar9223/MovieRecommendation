<?php

declare(strict_types=1);

namespace App\Utils\Docs;

use OpenApi\Attributes as OA;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::TARGET_PROPERTY | \Attribute::TARGET_PARAMETER | \Attribute::TARGET_CLASS_CONSTANT)]
final class DocsPropertyArray extends OA\Property
{
    public function __construct(array $items = [], bool $nullable = false, bool $multipleItems = false)
    {
        if (empty($items)) {
            parent::__construct(type: 'array', items: new OA\Items(type: 'string'), nullable: $nullable);
        } else {
            $properties = [];
            foreach ($items as $name => $type) {
                $format = null;
                if ($type === 'date') {
                    $format = 'date';
                    $type = 'string';
                } elseif ($type === 'datetime') {
                    $format = 'date-time';
                    $type = 'string';
                }
                $properties[] = new OA\Property(property: $name, type: $type, format: $format);
            }

            if ($multipleItems) {
                parent::__construct(type: 'array', items: new OA\Items(properties: $properties), nullable: $nullable);
            } else {
                parent::__construct(properties: $properties, type: 'object', nullable: $nullable);
            }
        }
    }
}
