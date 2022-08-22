<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Value\Event;

use Seasalt\Nicoca\Components\Domain\ValueObject\DateTimeValue;

final class OccurredDateTime
{
    use DateTimeValue;

    /**
     * 文字列との変換で使用される日付フォーマット
     *
     * @return string
     */
    private static function getFormat(): string
    {
        return 'Y-m-d\TH:i:s.u\Z';
    }
}
