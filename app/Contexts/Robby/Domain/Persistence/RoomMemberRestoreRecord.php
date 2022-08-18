<?php

declare(strict_types=1);

namespace App\Contexts\Robby\Domain\Persistence;

use App\Core\Domain\Persistence\RoomRestoreRecord;
use App\Core\Domain\Value;

/**
 * リポジトリで利用するDTO
 *
 * @see RoomMemberRepository::restore
 */
final class RoomMemberRestoreRecord
{
    public function __construct(
        public readonly Value\Member\Id $id,
        public readonly RoomRestoreRecord|null $roomRecord,
    )
    {

    }
}
