<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Persistence;

use App\Contexts\Core\Infrastructure\Persistence\RoomRecordCreatable;
use App\Contexts\EventJournal\Domain\Persistence\RoomMemberRestoreRecord;

trait RoomMemberRecordCreatable
{
    use RoomRecordCreatable;

    private function createMemberRecord(array $row): RoomMemberRestoreRecord
    {
        $room = null;
        if (!empty($row['rooms'][0])) {
            $room = $this->createRoomRecord($row['rooms'][0]);
        }
        return new RoomMemberRestoreRecord(
            id: $row['id'],
            name: $row['profile']['name'] ?? $row['name'],
            roomRecord: $room,
        );
    }
}
