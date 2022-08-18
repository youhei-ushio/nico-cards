<?php

declare(strict_types=1);

namespace App\Core\Domain\Persistence;

use App\Core\Domain\Value;

/**
 * リポジトリで利用するDTO
 *
 * @see RoomListRepository::restore
 */
final class RoomRestoreRecord
{
    /**
     * @param Value\Room\Id $id
     * @param Value\Room\Name $name
     * @param MemberRestoreRecord[] $members
     */
    public function __construct(
        public readonly Value\Room\Id $id,
        public readonly Value\Room\Name $name,
        public readonly array $members,
    )
    {

    }
}
