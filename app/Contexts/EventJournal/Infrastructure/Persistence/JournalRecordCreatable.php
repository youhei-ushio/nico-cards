<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Persistence;

use App\Contexts\Core\Infrastructure\Persistence\CardRecordCreatable;
use App\Contexts\EventJournal\Domain\Persistence\JournalRestoreRecord;

trait JournalRecordCreatable
{
    use CardRecordCreatable;

    private function createJournalRecord(array $row): JournalRestoreRecord
    {
        $cardRecords = [];
        if (!empty($row['payload'])) {
            $payload = json_decode(json: $row['payload'], associative: true);
            foreach ($payload as $cardRow) {
                $cardRecords[] = self::createCardRecord($cardRow);
            }
        }
        return new JournalRestoreRecord(
            id: $row['id'],
            type: $row['type'],
            roomId: $row['room_id'],
            memberId: $row['user_id'],
            cards: $cardRecords,
        );
    }
}
