<?php

declare(strict_types=1);

namespace App\Core\Domain\Value\Room;

use Seasalt\Nicoca\Components\Domain\ValueObject\IntegerValue;

/**
 * 部屋ID
 */
final class Id
{
    use IntegerValue;
}
