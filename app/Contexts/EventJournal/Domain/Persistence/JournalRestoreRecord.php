<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Persistence;

use App\Contexts\Core\Domain\Persistence\CardRestoreRecord;

/**
 * リポジトリで利用するDTO
 * @see JournalListRepository::restore()
 */
final class JournalRestoreRecord
{
    /**
     * @param int $id
     * @param string $type
     * @param int|null $roomId
     * @param int|null $memberId
     * @param string|null $memberName
     * @param CardRestoreRecord[] $cards
     */
    public function __construct(
        public readonly int $id,
        public readonly string $type,
        public readonly int|null $roomId,
        public readonly int|null $memberId,
        public readonly string|null $memberName,
        public readonly array $cards,
    )
    {

    }
}
