<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Value\Member;

use Seasalt\Nicoca\Components\Domain\ValueObject\IntegerValue;
use Seasalt\Nicoca\Components\Domain\ValueObject\InvalidValueException;

/**
 * メンバーID
 */
final class Id
{
    use IntegerValue;

    /** @var int 対象なし */
    private const EVERYONE = 0;

    public function isEveryone(): bool
    {
        return $this->value === self::EVERYONE;
    }

    public static function everyone(): self
    {
        return self::fromNumber(self::EVERYONE);
    }

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
