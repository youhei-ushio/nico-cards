<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Persistence;

/**
 * リポジトリで利用するDTO
 *
 * @see RoundSaveRecord
 */
final class UpcardSaveRecord
{
    /**
     * @param int $playerId
     * @param CardSaveRecord[] $cards
     */
    public function __construct(
        public readonly int $playerId,
        public readonly array $cards,
    )
    {

    }
}
