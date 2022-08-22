<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\UseCase\Room\Leave;

use App\Contexts\Core\Domain\Persistence\RoomRepository;
use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\Journal;
use App\Contexts\EventJournal\Domain\Entity\RoomMember;
use App\Contexts\EventJournal\Domain\Persistence\EventMessageRepository;
use App\Contexts\EventJournal\Domain\Persistence\EventMessageSaveRecord;
use App\Contexts\EventJournal\Domain\Persistence\RoomMemberRepository;

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
        $member = RoomMember::restore($this->roomMemberRepository->restore($journal->memberId));
        $member->leave();
        $member->save($this->roomMemberRepository);

        $this->eventMessageRepository->save(new EventMessageSaveRecord(
            $journal,
            Value\Event\Message\Body::fromString(__('lobby.room.left', ['name' => $room->name])),
            Value\Event\Message\Level::info(),
        ));
    }
}
