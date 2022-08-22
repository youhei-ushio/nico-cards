<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Persistence;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Persistence\JournalRestoreRecord;

trait JournalRecordCreatable
{
    private function createJournalRecord(array $row): JournalRestoreRecord
    {
        $type = Value\Event\Type::fromString($row['type']);
        $id = Value\Event\Id::fromNumber($row['id']);
        $roomId = Value\Room\Id::fromNumber($row['room_id']);
        $memberId = Value\Member\Id::fromNumber($row['user_id']);
        return new JournalRestoreRecord(
            id: $id,
            type: $type,
            roomId: $roomId,
            memberId: $memberId,
            card: null,
        );
    }
}
