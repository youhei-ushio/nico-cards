<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Persistence;

/**
 * リポジトリで利用するDTO
 */
final class CardRestoreRecord
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
