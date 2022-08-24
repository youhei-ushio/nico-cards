<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Value\Game\Round;

use Seasalt\Nicoca\Components\Domain\ValueObject\IntegerValue;

/**
 * ターン数
 */
final class Turn
{
    use IntegerValue;

    /**
     * 次ターン
     *
     * @return $this
     */
    public function next(): self
    {
        return new self($this->value + 1);
    }

    /**
     * 最初のターン
     *
     * @return self
     */
    public static function first(): self
    {
        return self::fromNumber(self::getMinValue());
    }

    /**
     * 最小値を取得する
     *
     * @return int
     */
    private static function getMinValue(): int
    {
        return 1;
    }

    /**
     * 最大値を取得する
     *
     * @return int
     */
    private static function getMaxValue(): int
    {
        return 999;
    }
}
