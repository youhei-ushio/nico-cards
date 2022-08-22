<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Value\Event;

use Seasalt\Nicoca\Components\Domain\ValueObject\StringValue;

/**
 * イベント種別
 */
final class Type
{
    use StringValue;

    private const VALUES = [
        'enter',
        'leave',
        'start',
        'deal',
        'play',
        'pass',
        'end',
    ];

    /**
     * 文字数の下限値
     *
     * @return int
     * @noinspection PhpUnusedPrivateMethodInspection
     */
    private static function getMinLength(): int
    {
        return 1;
    }

    /**
     * 文字数の上限値
     *
     * @return int
     * @noinspection PhpUnusedPrivateMethodInspection
     */
    private static function getMaxLength(): int
    {
        return 20;
    }

    /**
     * 有効な値か確認する
     *
     * 実装クラスでの制限用
     *
     * @param string|null $value
     * @return bool
     */
    public static function isValidValue(string|null $value): bool
    {
        return in_array($value, self::VALUES);
    }
}
