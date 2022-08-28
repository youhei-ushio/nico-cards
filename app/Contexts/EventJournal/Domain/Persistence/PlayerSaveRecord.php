<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Persistence;

/**
 * リポジトリで利用するDTO
 */
final class PlayerSaveRecord
{
    /**
     * @param int $id
     * @param CardSaveRecord[] $hand
     * @param bool $onTurn
     * @param int $rank
     */
    public function __construct(
        public readonly int $id,
        public readonly array $hand,
        public readonly bool $onTurn,
        public readonly int $rank,
    )
    {

    }
}
