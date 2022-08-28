<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Value\Game\Round;

use Seasalt\Nicoca\Components\Domain\ValueObject\IntegerValue;

final class Rank
{
    use IntegerValue;

    private const EMPTY = 0;

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->value === self::EMPTY;
    }

    /**
     * @return static
     */
    public static function empty(): self
    {
        return self::fromNumber(self::EMPTY);
    }

    /**
     * 最小値を取得する
     *
     * @return int
     */
    private static function getMinValue(): int
    {
        return 0;
    }

    /**
     * 最大値を取得する
     *
     * @return int
     */
    private static function getMaxValue(): int
    {
        return PHP_INT_MAX;
    }
}
