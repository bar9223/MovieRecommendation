<?php

declare(strict_types=1);

namespace App\Utils\DBAL\Types;

class MovieFilterType extends AbstractEnumType
{
    public const SESSION_STATUS_TYPE = 'movie_filter_type';
    public final const RANDOM = 'random';
    public final const W_AND_EVEN = 'w_and_even';
    public final const MORE_WORDS = 'more_words';

    final public const ENUM_LIST = [
        self::RANDOM,
        self::W_AND_EVEN,
        self::MORE_WORDS
    ];

    public function getName(): string
    {
        return self::SESSION_STATUS_TYPE;
    }

    protected function getEnumList(): array
    {
        return [
            self::RANDOM,
            self::W_AND_EVEN,
            self::MORE_WORDS
        ];
    }
}
