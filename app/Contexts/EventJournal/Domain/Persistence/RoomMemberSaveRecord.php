<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Persistence;

/**
 * リポジトリで利用するDTO
 *
 * @see RoomMemberRepository::save
 */
final class RoomMemberSaveRecord
{
    public function __construct(
        public readonly int $memberId,
        public readonly int|null $roomId,
    )
    {

    }
}
