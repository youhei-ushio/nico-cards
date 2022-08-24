<?php

declare(strict_types=1);

namespace App\Contexts\Core\Infrastructure\Persistence;

use App\Contexts\Core\Domain\Persistence\RoomRestoreRecord;

trait RoomRecordCreatable
{
    use MemberRecordCreatable;

    private function createRoomRecord(array $row): RoomRestoreRecord
    {
        $members = array_map(function (array $userRow) {
            return $this->createMemberRecord($userRow);
        }, $row['users'] ?? []);
        return new RoomRestoreRecord(
            id: $row['id'],
            name: $row['name'],
            members: $members,
        );
    }
}
