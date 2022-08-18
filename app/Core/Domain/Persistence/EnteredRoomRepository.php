<?php

declare(strict_types=1);

namespace App\Core\Domain\Persistence;

use App\Core\Domain\Value;

/**
 * メンバーが入室した部屋のリポジトリ
 */
interface EnteredRoomRepository
{
    /**
     * @param Value\Member\Id $id
     * @return RoomRestoreRecord|null
     */
    public function restore(Value\Member\Id $id): RoomRestoreRecord|null;
}
