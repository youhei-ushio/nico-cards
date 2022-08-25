<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Entity;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Exception\CannotEnterRoomException;
use App\Contexts\EventJournal\Domain\Persistence\RoomMemberRepository;
use App\Contexts\EventJournal\Domain\Persistence\RoomMemberRestoreRecord;
use App\Contexts\EventJournal\Domain\Persistence\RoomMemberSaveRecord;

/**
 * 部屋のメンバー
 */
final class RoomMember
{
    /**
     * newによるインスタンス化はさせない
     *
     * @param Value\Member\Id $id
     * @param Value\Member\Name $name
     * @param Value\Room|null $room
     * @see restore()
     */
    private function __construct(
        private readonly Value\Member\Id $id,
        public readonly Value\Member\Name $name,
        private Value\Room|null $room,
    )
    {

    }

    /**
     * @return bool
     */
    public function isInLobby(): bool
    {
        return $this->room === null;
    }

    /**
     * @param Value\Room $room
     * @return bool
     */
    public function isIn(Value\Room $room): bool
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
        if ($room->isFull) {
            throw new CannotEnterRoomException();
        }
        if (!$this->isInLobby()) {
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
     * @param Value\Member $member
     * @return bool
     */
    public function equals(Value\Member $member): bool
    {
        return $this->id->equals($member->id);
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
            id: Value\Member\Id::fromNumber($record->id),
            name: Value\Member\Name::fromString($record->name),
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
        $repository->save(new RoomMemberSaveRecord(
            $this->id->getValue(),
            $this->room?->id?->getValue(),
        ));
    }
}
