<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Persistence;

use App\Contexts\Core\Domain\Value;
use Iterator;

/**
 * 部屋のリポジトリ
 */
interface JournalListRepository extends Iterator
{
    /**
     * @return void
     */
    public function restore(Value\Room\Id $roomId): void;

    /**
     * @return JournalRestoreRecord
     */
    public function current(): JournalRestoreRecord;

    /**
     * @return int
     */
    public function key(): int;

    /**
     * @return bool
     */
    public function empty(): bool;
}
