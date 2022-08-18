<?php

declare(strict_types=1);

namespace App\Contexts\Game\Domain\Persistence;

use App\Core\Domain\Persistence\RoomRestoreRecord;
use App\Core\Domain\Value;

/**
 * リポジトリで利用するDTO
 *
 * @see PlayerRepository::restore
 */
final class PlayerRestoreRecord
{
    public function __construct(
        public readonly Value\Member\Name $name,
        public readonly RoomRestoreRecord $roomRecord,
    )
    {

    }
}
