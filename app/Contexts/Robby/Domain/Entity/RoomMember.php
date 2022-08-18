<?php

declare(strict_types=1);

namespace App\Contexts\Robby\Domain\Entity;

use App\Contexts\Robby\Domain\Exception\CannotEnterRoomException;
use App\Contexts\Robby\Domain\Persistence\RoomMemberRepository;
use App\Contexts\Robby\Domain\Persistence\RoomMemberRestoreRecord;
use App\Contexts\Robby\Domain\Persistence\RoomMemberSaveRecord;
use App\Core\Domain\Value;

/**
 * 部屋のメンバー
 */
final class RoomMember
{
    /**
     * newによるインスタンス化はさせない
     *
     * @param Value\Member\Id $id
     * @param Value\Room|null $room
     * @see restore()
     */
    private function __construct(
        private readonly Value\Member\Id $id,
        private Value\Room|null $room,
    )
    {

    }

    /**
     * 滞在中の部屋
     *
     * @return Value\Room|null
     */
    public function stayIn(): Value\Room|null
    {
        return $this->room;
    }

    /**
     * @param Value\Room $room
     * @return bool
     */
    public function isStayedIn(Value\Room $room): bool
    {
        return $this->room?->id?->equals($room->id) ?? false;
    }

    /**
     * 入室する
     *
     * @param Value\Room $room
     * @return void
     */
    public function enter(Value\Room $room): void
    {
        if (!$room->canEnter) {
            throw new CannotEnterRoomException();
        }
        if ($this->isStayedIn($room)) {
            throw new CannotEnterRoomException();
        }
        $this->room = $room;
    }

    /**
     * 退室する
     *
     * @return void
     */
    public function leave(): void
    {
        $this->room = null;
    }

    /**
     * 永続化されたエンティティを復元する
     *
     * @param RoomMemberRestoreRecord $record
     * @return self
     */
    public static function restore(RoomMemberRestoreRecord $record): self
    {
        $room = null;
        if ($record->roomRecord !== null) {
            $room = Value\Room::restore($record->roomRecord);
        }
        return new self(
            id: $record->id,
            room: $room,
        );
    }

    /**
     * エンティティを永続化する
     *
     * @param RoomMemberRepository $repository
     * @return void
     */
    public function save(RoomMemberRepository $repository): void
    {
        $repository->save(new RoomMemberSaveRecord($this->id, $this->room));
    }
}
