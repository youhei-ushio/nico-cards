<?php

declare(strict_types=1);

namespace App\Core\Domain\Persistence;

use Iterator;

/**
 * 部屋のリポジトリ
 */
interface RoomListRepository extends Iterator
{
    /**
     * @return void
     */
    public function restore(): void;

    /**
     * @return RoomRestoreRecord
     */
    public function current(): RoomRestoreRecord;

    /**
     * @return int
     */
    public function key(): int;
}
