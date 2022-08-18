<?php

declare(strict_types=1);

namespace App\Core\Domain\Value\Member;

use Seasalt\Nicoca\Components\Domain\ValueObject\IntegerValue;

/**
 * メンバーID
 */
final class Id
{
    use IntegerValue;
}
