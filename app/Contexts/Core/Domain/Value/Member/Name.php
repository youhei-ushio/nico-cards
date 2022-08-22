<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Value\Member;

use Seasalt\Nicoca\Components\Domain\ValueObject\StringValue;

/**
 * 表示名
 */
final class Name
{
    use StringValue;

    /**
     * @return bool
     */
    public function empty(): bool
    {
        return $this->value === '';
    }

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
        return 30;
    }
}
