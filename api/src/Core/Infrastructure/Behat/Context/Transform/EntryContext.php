<?php
declare(strict_types=1);

namespace App\Core\Infrastructure\Behat\Context\Transform;

use App\Common\Enum\EntryType;
use Behat\Behat\Context\Context;

final class EntryContext implements Context
{
    /**
     * @Transform :entryType
     */
    public function entryType(string $entryType) : ?EntryType
    {
        return new EntryType($entryType);
    }
}
