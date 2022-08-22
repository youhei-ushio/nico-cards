<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Value\Room;

use Seasalt\Nicoca\Components\Domain\ValueObject\StringValue;

/**
 * 部屋名
 */
final class Name
{
    use StringValue;

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
        return 30;
    }
}
