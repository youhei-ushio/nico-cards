<?php

declare(strict_types=1);

namespace App\Contexts\Game\Domain\Persistence;

use App\Contexts\Core\Domain\Persistence\RoomRestoreRecord;
use App\Contexts\Core\Domain\Value;

/**
 * 部屋のリポジトリ
 */
interface RoomRepository
{
    /**
     * @param Value\Member\Id $id
     * @return RoomRestoreRecord
     */
    public function restore(Value\Member\Id $id): RoomRestoreRecord;
}
