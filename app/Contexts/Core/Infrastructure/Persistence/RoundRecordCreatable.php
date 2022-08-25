<?php

declare(strict_types=1);

namespace App\Contexts\Core\Infrastructure\Persistence;

use App\Contexts\Core\Domain\Persistence\CardRestoreRecord;
use App\Contexts\Core\Domain\Persistence\RoundRestoreRecord;

trait RoundRecordCreatable
{
    use PlayerRecordCreatable;
    use UpcardRecordCreatable;

    private function createRoundRecord(array $row): RoundRestoreRecord
    {
        $players = array_map(function (array $userRow) use ($row) {
            return $this->createPlayerRecord($userRow);
        }, $row['users'] ?? []);

        return new RoundRestoreRecord(
            id: $row['id'],
            roomId: $row['room_id'],
            upcard: self::createUpcardRecord($row['upcards'] ?? []),
            turn: $row['turn'],
            reversed: $row['reversed'] === 1,
            playerRecords: $players,
        );
    }
}
