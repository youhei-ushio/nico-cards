<?php

declare(strict_types=1);

namespace App\Contexts\Game\Domain\Persistence;

use App\Contexts\Core\Domain\Persistence\RoomRestoreRecord;
use App\Contexts\Core\Domain\Value;

interface RoomRepository
{
    public function restore(Value\Member\Id $memberId): RoomRestoreRecord;
}
