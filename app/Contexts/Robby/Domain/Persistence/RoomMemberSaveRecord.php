<?php

declare(strict_types=1);

namespace App\Contexts\Robby\Domain\Persistence;

use App\Core\Domain\Value;

/**
 * リポジトリで利用するDTO
 *
 * @see RoomMemberRepository::save
 */
final class RoomMemberSaveRecord
{
    public function __construct(
        public readonly Value\Member\Id $id,
        public readonly Value\Room|null $room,
    )
    {

    }
}
