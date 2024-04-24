<?php

declare(strict_types=1);

namespace App\Utils\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;

abstract class AbstractEnumType extends Type
{
    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): mixed
    {
        if (null !== $value && !in_array($value, $this->getEnumList(), true)) {
            throw new InvalidArgumentException('Invalid enum value');
        }

        return $value;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): mixed
    {
        return $value;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        if (empty($this->getEnumList())) {
            throw new InvalidArgumentException('Empty enum list');
        }

        return vsprintf('ENUM(' . implode(',', array_fill(0, count($this->getEnumList()), "'%s'")) . ')', $this->getEnumList());
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    abstract protected function getEnumList(): array;
}
