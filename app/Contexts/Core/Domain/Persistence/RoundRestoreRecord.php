<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Persistence;

/**
 * リポジトリで利用するDTO
 */
final class RoundRestoreRecord
{
    /**
     * @param int $id
     * @param int $roomId
     * @param UpcardRestoreRecord|null $upcard
     * @param int $turn
     * @param bool $reversed
     * @param PlayerRestoreRecord[] $playerRecords
     * @param bool $finished
     */
    public function __construct(
        public readonly int $id,
        public readonly int $roomId,
        public readonly UpcardRestoreRecord|null $upcard,
        public readonly int $turn,
        public readonly bool $reversed,
        public readonly array $playerRecords,
        public readonly bool $finished,
    )
    {

    }
}
