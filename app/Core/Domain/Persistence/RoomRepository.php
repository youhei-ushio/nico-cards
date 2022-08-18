<?php

declare(strict_types=1);

namespace App\Core\Domain\Persistence;

use App\Core\Domain\Value;

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
