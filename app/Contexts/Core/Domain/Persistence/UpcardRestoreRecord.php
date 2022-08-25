<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Persistence;

/**
 * リポジトリで利用するDTO
 */
final class UpcardRestoreRecord
{
    /**
     * @param int $playerId
     * @param CardRestoreRecord[] $cards
     */
    public function __construct(
        public readonly int $playerId,
        public readonly array $cards,
    )
    {

    }
}
