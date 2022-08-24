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
     * @param CardRestoreRecord[] $upcards
     * @param int $turn
     * @param bool $reversed
     * @param PlayerRestoreRecord[] $playerRecords
     */
    public function __construct(
        public readonly int $id,
        public readonly int $roomId,
        public readonly array $upcards,
        public readonly int $turn,
        public readonly bool $reversed,
        public readonly array $playerRecords,
    )
    {

    }
}
