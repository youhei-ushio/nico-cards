<?php

declare(strict_types=1);

namespace App\Contexts\Core\Infrastructure\Persistence;

use App\Contexts\Core\Domain\Persistence\EventMessageRestoreRecord;
use App\Contexts\Core\Domain\Value;
use App\Contexts\Core\Domain\Persistence\RoomEventMessageListRepository;
use App\Models;

final class RoomEventMessageListRepositoryImpl implements RoomEventMessageListRepository
{
    use EventMessageRecordCreatable;

    /** @var array */
    private array $rows = [];

    public function restore(Value\Member\Id $memberId, Value\Room\Id $roomId): void
    {
        $this->rows = Models\EventMessage::query()
            ->where('user_id', $memberId->getValue())
            ->where('room_id', $roomId->getValue())
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get()
            ->sortBy('id')
            ->toArray();
    }

    function rewind(): void
    {
        reset($this->rows);
    }

    function current(): EventMessageRestoreRecord
    {
        return $this->createEventMessageRecord(current($this->rows));
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
