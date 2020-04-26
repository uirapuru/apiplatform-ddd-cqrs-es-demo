<?php

namespace App\Infrastructure\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use App\Common\ValueObject\Price as PriceVO;

class Price extends Type
{
    const NAME = "price";

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    public function getName()
    {
        return self::NAME;
    }

    /**
     * @param PriceVO $value
     * @param AbstractPlatform $platform
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if($value === null) {
            return "";
        }

        return sprintf("%s|%s", $value->amount(), $value->currency());
    }

    public function convertToPHPValue($value, AbstractPlatform $platform) : PriceVO
    {
        return new PriceVO(...explode("|", $value));
    }
}
