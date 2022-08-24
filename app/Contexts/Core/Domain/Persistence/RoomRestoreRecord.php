<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Persistence;

use App\Contexts\Lobby\Domain\Persistence\RoomListRepository;

/**
 * リポジトリで利用するDTO
 *
 * @see RoomListRepository::restore
 */
final class RoomRestoreRecord
{
    /**
     * @param int $id
     * @param string $name
     * @param MemberRestoreRecord[] $members
     */
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly array $members,
    )
    {

    }
}
