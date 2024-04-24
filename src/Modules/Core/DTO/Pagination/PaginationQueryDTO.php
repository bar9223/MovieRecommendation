<?php

declare(strict_types=1);

namespace App\Modules\Core\DTO\Pagination;

use App\Component\DTO\AbstractValidatorDTO;
use App\Utils\Docs\DocsGroup;
use Symfony\Component\Validator\Constraints as Assert;

class PaginationQueryDTO extends AbstractValidatorDTO
{
    #[Assert\PositiveOrZero]
    #[DocsGroup]
    public ?int $id = null;

    #[Assert\LessThanOrEqual(200)]
    #[Assert\Positive]
    #[Assert\NotBlank]
    #[DocsGroup]
    public int $limit = 100;

    #[Assert\PositiveOrZero]
    #[Assert\NotBlank]
    #[DocsGroup]
    public int $offset = 0;
}
