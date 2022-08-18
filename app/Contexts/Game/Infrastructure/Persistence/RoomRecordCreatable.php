<?php

declare(strict_types=1);

namespace App\Contexts\Game\Infrastructure\Persistence;

use App\Core\Domain\Persistence\RoomRestoreRecord;
use App\Core\Domain\Value;

trait RoomRecordCreatable
{
    use MemberRecordCreatable;

    private function createRoomRecord(array $row): RoomRestoreRecord
    {
        $id = Value\Room\Id::fromNumber($row['id']);
        $name = Value\Room\Name::fromString($row['name']);
        $members = array_map(function (array $userRow) {
            return $this->createMemberRecord($userRow);
        }, $row['users'] ?? []);
        return new RoomRestoreRecord(
            $id,
            $name,
            $members,
        );
    }
}
