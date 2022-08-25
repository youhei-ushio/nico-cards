<?php

declare(strict_types=1);

namespace App\Contexts\Core\Infrastructure\Persistence;

use App\Contexts\Core\Domain\Persistence\EventRepository;
use App\Contexts\Core\Domain\Persistence\EventSaveRecord;
use App\Models;
use Throwable;

final class EventRepositoryImpl implements EventRepository
{
    private int $lastEventId = 0;

    /**
     * @inheritDoc
     * @throws Throwable
     */
    public function save(EventSaveRecord $record): void
    {
        $row = new Models\Journal();
        $row->fill([
            'type' => $record->type,
            'user_id' => $record->memberId?->getValue(),
            'room_id' => $record->roomId?->getValue(),
            'payload' => $record->payload !== null ? json_encode($record->payload) : null,
        ])
        ->saveOrFail();
        $this->lastEventId = $row->id;
    }

    /**
     * @inheritDoc
     * @throws Throwable
     */
    public function waitForLastEvent(): void
    {
        if ($this->lastEventId === 0) {
            return;
        }
        while (true) {
            $exists = Models\Snapshot::query()
                ->where('journal_id', '>=', $this->lastEventId)
                ->exists();
            if ($exists) {
                break;
            }
            sleep(1);
        }
    }
}
