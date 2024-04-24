<?php

declare(strict_types=1);

namespace App\Modules\Core\DTO\Pagination;

use App\Component\DTO\AbstractValidatorDTO;
use Symfony\Component\Validator\Constraints as Assert;

class PaginationSearchDTO extends AbstractValidatorDTO
{
    #[Assert\Type(type: 'string')]
    #[Assert\Length(min: 3, max: 40)]
    public ?string $searchQuery = null;
}
