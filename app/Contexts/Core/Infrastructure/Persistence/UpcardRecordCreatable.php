<?php

declare(strict_types=1);

namespace App\Contexts\Core\Infrastructure\Persistence;

use App\Contexts\Core\Domain\Persistence\CardRestoreRecord;
use App\Contexts\Core\Domain\Persistence\UpcardRestoreRecord;

trait UpcardRecordCreatable
{
    private function createUpcardRecord(array $upcardRows): UpcardRestoreRecord|null
    {
        if (empty($upcardRows)) {
            return null;
        }
        $playerId = $upcardRows[0]['user_id'];
        $cards = array_map(function (array $cardRow) {
            return new CardRestoreRecord(
                suit: $cardRow['suit'],
                number: $cardRow['number'],
            );
        }, $upcardRows);

        return new UpcardRestoreRecord(
            playerId: $playerId,
            cards: $cards,
        );
    }
}
