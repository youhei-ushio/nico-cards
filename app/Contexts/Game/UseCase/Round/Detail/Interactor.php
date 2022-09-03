<?php

declare(strict_types=1);

namespace App\Contexts\Game\UseCase\Round\Detail;

use App\Contexts\Core\Domain\Persistence\RoomEventMessageListRepository;
use App\Contexts\Core\Domain\Value;
use App\Contexts\Game\Domain\Persistence\MemberRepository;
use App\Contexts\Game\Domain\Persistence\RoomRepository;
use App\Contexts\Game\Domain\Persistence\RoundRepository;
use App\Contexts\Game\Domain\Value\Round;

final class Interactor
{
    public function __construct(
        private readonly MemberRepository $memberRepository,
        private readonly RoomRepository $roomRepository,
        private readonly RoundRepository $roundRepository,
        private readonly RoomEventMessageListRepository $eventMessageListRepository,
    )
    {

    }

    public function execute(Input $input): Output
    {
        $member = Value\Member::restore($this->memberRepository->restore($input->memberId));
        $room = Value\Room::restore($this->roomRepository->restore($input->memberId));
        $round = Round::restore($member->id, $this->roundRepository->restore($member->id));
        $this->eventMessageListRepository->restore($input->memberId, $room->id);
        $messages = Value\Event\Message::restoreList($this->eventMessageListRepository);
        return new Output(
            member: $member,
            room: $room,
            round: $round,
            messages: $messages,
        );
    }
}
