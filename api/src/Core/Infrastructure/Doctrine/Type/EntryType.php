<?php

namespace App\Infrastructure\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use App\Common\Enum\EntryType as EntryTypeEnum;

class EntryType extends Type
{
    const NAME = "entryType";

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    public function getName()
    {
        return self::NAME;
    }

    /**
     * @param EntryTypeEnum $value
     * @param AbstractPlatform $platform
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return sprintf("%s", $value->getValue());
    }

    public function convertToPHPValue($value, AbstractPlatform $platform) : EntryTypeEnum
    {
        return new EntryTypeEnum($value);
    }
}
