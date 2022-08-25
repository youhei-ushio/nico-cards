<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Persistence;

use App\Contexts\Core\Domain\Persistence\PlayerSaveRecord;

final class RoundSaveRecord
{
    /**
     * @param int|null $id
     * @param int $roomId
     * @param int $turn
     * @param bool $reversed
     * @param bool $finished
     * @param PlayerSaveRecord[] $players
     * @param UpcardSaveRecord|null $upcard
     */
    public function __construct(
        public readonly int|null $id,
        public readonly int $roomId,
        public readonly int $turn,
        public readonly bool $reversed,
        public readonly bool $finished,
        public readonly array $players,
        public readonly UpcardSaveRecord|null $upcard,
    )
    {

    }
}
