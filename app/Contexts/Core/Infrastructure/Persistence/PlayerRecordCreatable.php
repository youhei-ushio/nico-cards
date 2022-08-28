<?php

declare(strict_types=1);

namespace App\Contexts\Core\Infrastructure\Persistence;

use App\Contexts\Core\Domain\Persistence\CardRestoreRecord;
use App\Contexts\Core\Domain\Persistence\PlayerRestoreRecord;

trait PlayerRecordCreatable
{
    private function createPlayerRecord(array $row): PlayerRestoreRecord
    {
        $hand = array_map(function (array $cardRow) {
            return new CardRestoreRecord(
                $cardRow['suit'],
                $cardRow['number'],
            );
        }, $row['hand'] ?? []);

        return new PlayerRestoreRecord(
            id: $row['user_id'],
            name: $row['profile']['name'] ?? $row['user']['name'],
            onTurn: $row['on_turn'] === 1,
            hand: $hand,
            rank: $row['rank'],
        );
    }
}
