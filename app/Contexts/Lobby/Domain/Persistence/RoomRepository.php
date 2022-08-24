<?php

declare(strict_types=1);

namespace App\Contexts\Lobby\Domain\Persistence;

use App\Contexts\Core\Domain\Persistence\RoomRestoreRecord;
use App\Contexts\Core\Domain\Value;

/**
 * 部屋のリポジトリ
 */
interface RoomRepository
{
    /**
     * @param Value\Room\Id $id
     * @return RoomRestoreRecord
     */
    public function restore(Value\Room\Id $id): RoomRestoreRecord;
}
