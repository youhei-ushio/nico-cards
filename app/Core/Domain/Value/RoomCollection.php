<?php

declare(strict_types=1);

namespace App\Core\Domain\Value;

use Iterator;

/**
 * 部屋一覧
 */
interface RoomCollection extends Iterator
{
    /**
     * @return Room
     */
    public function current(): Room;

    /**
     * @return int
     */
    public function key(): int;
}
