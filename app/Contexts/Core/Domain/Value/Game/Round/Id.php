<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Value\Game\Round;

use Seasalt\Nicoca\Components\Domain\ValueObject\IntegerValue;

/**
 * イベントジャーナルID
 */
final class Id
{
    use IntegerValue;
}
