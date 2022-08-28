<?php

declare(strict_types=1);

namespace App\Contexts\Lobby\Infrastructure\Persistence;

use App\Contexts\Core\Domain\Persistence\EventMessageRestoreRecord;
use App\Contexts\Core\Domain\Value;
use App\Contexts\Core\Infrastructure\Persistence\EventMessageRecordCreatable;
use App\Contexts\Lobby\Domain\Persistence\LobbyEventMessageListRepository;
use App\Models;

final class LobbyEventMessageListRepositoryImpl implements LobbyEventMessageListRepository
{
    use EventMessageRecordCreatable;

    /** @var array */
    private array $rows = [];

    public function restore(): void
    {
        $this->rows = Models\EventMessage::query()
            ->where('room_id', Value\Room\Id::lobby()->getValue())
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->sortBy('created_at')
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
