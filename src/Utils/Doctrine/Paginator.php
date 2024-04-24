<?php

declare(strict_types=1);

namespace App\Utils\Doctrine;

use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Symfony\Component\HttpFoundation\RequestStack;

class Paginator
{
    public final const PAGE = 1;

    public final const LIMIT = 10;

    /**
     * Paginator constructor.
     */
    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    public function paginate(Query $dql): DoctrinePaginator
    {
        $page = $this->getPage();
        $limit = $this->getLimit();
        $paginator = new DoctrinePaginator($dql);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);

        return $paginator;
    }

    private function getPage(): int
    {
        $request = $this->requestStack->getCurrentRequest();

        return (int) ($request->query->get('page') ?? self::PAGE);
    }

    private function getLimit(): int
    {
        $request = $this->requestStack->getCurrentRequest();

        return (int) ($request->query->get('limit') ?? self::LIMIT);
    }
}
