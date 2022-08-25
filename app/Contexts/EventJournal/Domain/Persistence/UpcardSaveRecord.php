<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Persistence;

use App\Contexts\Core\Domain\Persistence\CardSaveRecord;

/**
 * リポジトリで利用するDTO
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