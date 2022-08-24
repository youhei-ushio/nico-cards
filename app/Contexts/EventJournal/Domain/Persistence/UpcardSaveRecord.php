<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Persistence;

/**
 * リポジトリで利用するDTO
 */
final class UpcardSaveRecord
{
    /**
     * @param int $roundId
     * @param string $suit
     * @param int $number
     */
    public function __construct(
        public readonly int $roundId,
        public readonly string $suit,
        public readonly int $number,
    )
    {

    }
}
