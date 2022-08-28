<?php

declare(strict_types=1);

namespace App\Contexts\Lobby\UseCase\Room\Index;

use App\Contexts\Core\Domain\Persistence\EventRepository;
use App\Contexts\Core\Domain\Value;
use App\Contexts\Lobby\Domain\Persistence\LobbyEventMessageListRepository;
use App\Contexts\Lobby\Domain\Persistence\MemberRepository;
use App\Contexts\Lobby\Domain\Persistence\RoomListRepository;

final class Interactor
{
    public function __construct(
        private readonly RoomListRepository $roomListRepository,
        private readonly MemberRepository $memberRepository,
        private readonly LobbyEventMessageListRepository $eventMessageListRepository,
        private readonly EventRepository $eventRepository,
    )
    {

    }

    public function execute(Input $input): Output
    {
        $this->roomListRepository->restore();
        $rooms = Value\Room::restoreList($this->roomListRepository);
        $member = Value\Member::restore($this->memberRepository->restore($input->memberId));
        $this->eventMessageListRepository->restore();
        $messages = Value\Event\Message::restoreList($this->eventMessageListRepository);
        return new Output(
            $rooms,
            $member,
            $messages,
            $this->eventRepository->lastEventId(),
        );
    }
}
