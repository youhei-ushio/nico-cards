<?php

declare(strict_types=1);

namespace App\Contexts\Robby\Infrastructure\Persistence;

use App\Contexts\Robby\Domain\Persistence\RoomMemberRestoreRecord;
use App\Core\Domain\Value;

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
