<?php

declare(strict_types=1);

namespace App\Contexts\Core\Infrastructure\Persistence;

use App\Contexts\Core\Domain\Persistence\CardRestoreRecord;

trait CardRecordCreatable
{
    private function createCardRecord(array $row): CardRestoreRecord
    {
        return new CardRestoreRecord(
            suit: $row['suit'],
            number: $row['number'],
        );
    }
}
