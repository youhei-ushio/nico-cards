<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Value\Event;

use Iterator;

/**
 * イベントメッセージ一覧
 */
interface MessageCollection extends Iterator
{
    /**
     * @return Message
     */
    public function current(): Message;

    /**
     * @return int
     */
    public function key(): int;

    /**
     * @return int
     */
    public function total(): int;

    /**
     * @return bool
     */
    public function empty(): bool;
}
