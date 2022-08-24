<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\UseCase\Room\Enter;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\Journal;
use App\Contexts\EventJournal\Domain\Entity\RoomMember;
use App\Contexts\EventJournal\Domain\Persistence\EventMessageRepository;
use App\Contexts\EventJournal\Domain\Persistence\EventMessageSaveRecord;
use App\Contexts\EventJournal\Domain\Persistence\RoomMemberRepository;
use App\Contexts\EventJournal\Domain\Persistence\RoomRepository;

final class Interactor
{
    public function __construct(
        private readonly RoomMemberRepository $roomMemberRepository,
        private readonly RoomRepository $roomRepository,
        private readonly EventMessageRepository $eventMessageRepository,
    )
    {

    }

    public function execute(Journal $journal): void
    {
        $room = Value\Room::restore($this->roomRepository->restore($journal->roomId));
        if ($room->isFull) {
            $this->eventMessageRepository->save(new EventMessageSaveRecord(
                $journal,
                Value\Event\Message\Body::fromString(__('lobby.room.room_is_full', ['name' => $room->name])),
                Value\Event\Message\Level::error(),
            ));
            return;
        }
        $member = RoomMember::restore($this->roomMemberRepository->restore($journal->memberId));
        if ($member->isIn($room)) {
            // 同じ部屋にいる場合は何もしない
            return;
        }
        if (!$member->isInLobby()) {
            $this->eventMessageRepository->save(new EventMessageSaveRecord(
                $journal,
                Value\Event\Message\Body::fromString(__('lobby.room.leave_first')),
                Value\Event\Message\Level::error(),
            ));
            return;
        }

        $member->enter($room);
        $member->save($this->roomMemberRepository);

        $this->eventMessageRepository->save(new EventMessageSaveRecord(
            $journal,
            Value\Event\Message\Body::fromString(__('lobby.room.entered', ['name' => $room->name])),
            Value\Event\Message\Level::info(),
        ));
    }
}
