<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Persistence;

use App\Contexts\Core\Domain\Persistence\CardRestoreRecord;

final class JournalRestoreRecord
{
    /**
     * @param int $id
     * @param string $type
     * @param int|null $roomId
     * @param int|null $memberId
     * @param CardRestoreRecord[] $cards
     */
    public function __construct(
        public readonly int $id,
        public readonly string $type,
        public readonly int|null $roomId,
        public readonly int|null $memberId,
        public readonly array $cards,
    )
    {

    }
}
