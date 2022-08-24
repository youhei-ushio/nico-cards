<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Persistence;

use App\Contexts\EventJournal\Domain\Persistence\SnapshotRepository;
use App\Contexts\EventJournal\Domain\Persistence\SnapshotSaveRecord;
use App\Models;
use Throwable;

final class SnapshotRepositoryImpl implements SnapshotRepository
{
    /**
     * @inheritDoc
     * @throws Throwable
     */
    public function save(SnapshotSaveRecord $record): void
    {
        (new Models\Snapshot)
            ->fill([
                'journal_id' => $record->id,
                'room_id' => $record->roomId,
            ])
            ->saveOrFail();
    }
}
