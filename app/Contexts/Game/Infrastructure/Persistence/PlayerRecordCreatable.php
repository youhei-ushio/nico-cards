<?php

declare(strict_types=1);

namespace App\Contexts\Game\Infrastructure\Persistence;

use App\Contexts\Game\Domain\Persistence\PlayerRestoreRecord;
use App\Contexts\Core\Domain\Value;

trait PlayerRecordCreatable
{
    use RoomRecordCreatable;

    private function createPlayerRecord(array $row): PlayerRestoreRecord
    {
        $id = Value\Member\Id::fromNumber($row['id']);
        $name = Value\Member\Name::fromString($row['name']);
        $room = $this->createRoomRecord($row['rooms'][0]);
        return new PlayerRestoreRecord(
            id: $id,
            name: $name,
            roomRecord: $room,
        );
    }
}
