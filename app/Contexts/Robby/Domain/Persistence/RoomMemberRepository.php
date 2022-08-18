<?php

declare(strict_types=1);

namespace App\Contexts\Robby\Domain\Persistence;

use App\Core\Domain\Value;

/**
 * 部屋メンバーリポジトリ
 */
interface RoomMemberRepository
{
    /**
     * @return RoomMemberRestoreRecord
     */
    public function restore(Value\Member\Id $id): RoomMemberRestoreRecord;

    /**
     * @param RoomMemberSaveRecord $record
     */
    public function save(RoomMemberSaveRecord $record): void;
}
