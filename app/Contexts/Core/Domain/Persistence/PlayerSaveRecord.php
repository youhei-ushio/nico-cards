<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Persistence;

/**
 * リポジトリで利用するDTO
 */
final class PlayerSaveRecord
{
    /**
     * @param int $id
     * @param CardSaveRecord[] $hand
     * @param bool $onTurn
     */
    public function __construct(
        public readonly int $id,
        public readonly array $hand,
        public readonly bool $onTurn,
    )
    {

    }
}
