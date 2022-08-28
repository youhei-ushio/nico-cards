<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Persistence;

use App\Contexts\Core\Domain\Persistence\RoomRestoreRecord;

/**
 * リポジトリで利用するDTO
 *
 * @see RoomMemberRepository::restore()
 */
final class RoomMemberRestoreRecord
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly RoomRestoreRecord|null $roomRecord,
    )
    {

    }
}
