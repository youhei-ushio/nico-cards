<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Value\Event\Message;

use Seasalt\Nicoca\Components\Domain\ValueObject\StringValue;

/**
 * イベントメッセージ本文
 */
final class Body
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
        return 0;
    }

    /**
     * 文字数の上限値
     *
     * @return int
     * @noinspection PhpUnusedPrivateMethodInspection
     */
    private static function getMaxLength(): int
    {
        return 200;
    }
}
