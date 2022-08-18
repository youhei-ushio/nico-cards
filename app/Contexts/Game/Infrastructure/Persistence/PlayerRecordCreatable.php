<?php

declare(strict_types=1);

namespace App\Contexts\Game\Infrastructure\Persistence;

use App\Contexts\Game\Domain\Persistence\PlayerRestoreRecord;
use App\Core\Domain\Value;

trait PlayerRecordCreatable
{
    use RoomRecordCreatable;

    private function createPlayerRecord(array $row): PlayerRestoreRecord
    {
        $name = Value\Member\Name::fromString($row['name']);
        $room = $this->createRoomRecord($row['rooms'][0]);
        return new PlayerRestoreRecord(
            $name,
            $room,
        );
    }
}
