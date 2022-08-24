<?php

declare(strict_types=1);

namespace App\Contexts\Lobby\Infrastructure\Persistence;

use App\Contexts\Core\Domain\Persistence\RoomRestoreRecord;
use App\Contexts\Core\Infrastructure\Persistence\RoomRecordCreatable;
use App\Contexts\Lobby\Domain\Persistence\RoomListRepository;
use App\Models;

final class RoomListRepositoryImpl implements RoomListRepository
{
    use RoomRecordCreatable;

    /** @var array */
    private array $rows = [];

    public function restore(): void
    {
        $this->rows = Models\Room::query()
            ->with([
                'users',
                'users.profile',
            ])
            ->get()
            ->toArray();
    }

    function rewind(): void
    {
        reset($this->rows);
    }

    function current(): RoomRestoreRecord
    {
        return $this->createRoomRecord(current($this->rows));
    }

    function key(): int
    {
        return key($this->rows);
    }

    function next(): void
    {
        next($this->rows);
    }

    function valid(): bool
    {
        return current($this->rows) !== false;
    }
}
