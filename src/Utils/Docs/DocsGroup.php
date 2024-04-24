<?php

declare(strict_types=1);

namespace App\Utils\Docs;

use Symfony\Component\Serializer\Annotation\Groups;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::TARGET_PROPERTY)]
final class DocsGroup extends Groups
{
    public function __construct()
    {
        parent::__construct('DOCS');
    }
}
