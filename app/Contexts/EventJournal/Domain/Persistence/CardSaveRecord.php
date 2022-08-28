<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Persistence;

/**
 * リポジトリで利用するDTO
 *
 * @see PlayerSaveRecord
 */
final class CardSaveRecord
{
    /**
     * @param string $suit
     * @param int $number
     */
    public function __construct(
        public readonly string $suit,
        public readonly int $number,
    )
    {

    }
}
