<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Persistence;

use App\Contexts\Core\Domain\Value;

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
