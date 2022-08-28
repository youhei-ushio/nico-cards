<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Persistence;

use App\Contexts\EventJournal\Domain\Persistence\EventMessageRepository;
use App\Contexts\EventJournal\Domain\Persistence\EventMessageSaveRecord;
use App\Models;
use Throwable;

final class EventMessageRepositoryImpl implements EventMessageRepository
{
    /**
     * @inheritDoc
     * @throws Throwable
     */
    public function save(EventMessageSaveRecord $record): void
    {
        (new Models\EventMessage())
            ->fill([
                'journal_id' => $record->journalId,
                'user_id' => $record->memberId,
                'room_id' => $record->roomId,
                'body' => $record->body,
                'level' => $record->level,
            ])
            ->saveOrFail();
    }
}
