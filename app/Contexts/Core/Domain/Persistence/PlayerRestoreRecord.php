<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Persistence;

/**
 * リポジトリで利用するDTO
 */
final class PlayerRestoreRecord
{
    /**
     * @param int $id
     * @param string $name
     * @param bool $onTurn
     * @param CardRestoreRecord[] $hand
     */
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly bool $onTurn,
        public readonly array $hand,
    )
    {

    }
}
