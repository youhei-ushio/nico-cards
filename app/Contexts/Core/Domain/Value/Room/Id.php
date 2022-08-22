<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Value\Room;

use Seasalt\Nicoca\Components\Domain\ValueObject\IntegerValue;
use Seasalt\Nicoca\Components\Domain\ValueObject\InvalidValueException;

/**
 * 部屋ID
 */
final class Id
{
    use IntegerValue;

    /**
     * 数値からオブジェクトを生成する
     *
     * @param int|null $value
     * @return self|null
     */
    public static function fromNumber(int|null $value): self|null
    {
        if ($value === null) {
            return null;
        }
        if (!self::isValidValue($value)) {
            throw new InvalidValueException((string)$value, self::class);
        }
        return new self($value);
    }
}
