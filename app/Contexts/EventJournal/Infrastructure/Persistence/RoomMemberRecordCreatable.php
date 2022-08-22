<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Persistence;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Persistence\RoomMemberRestoreRecord;
use App\Contexts\Lobby\Infrastructure\Persistence\RoomRecordCreatable;

trait RoomMemberRecordCreatable
{
    use RoomRecordCreatable;

    private function createMemberRecord(array $row): RoomMemberRestoreRecord
    {
        $id = Value\Member\Id::fromNumber($row['id']);
        $room = null;
        if (!empty($row['rooms'][0])) {
            $room = $this->createRoomRecord($row['rooms'][0]);
        }
        return new RoomMemberRestoreRecord(
            $id,
            $room,
        );
    }
}
