<?php

declare(strict_types=1);

namespace App\Contexts\Robby\UseCase\Room\Enter;

use App\Contexts\Robby\Domain\Persistence\RoomMemberRepository;
use App\Contexts\Robby\Domain\Entity\RoomMember;
use App\Core\Domain\Persistence\RoomRepository;
use App\Core\Domain\Value\Room;

final class Interactor
{
    public function __construct(
        private readonly RoomRepository $roomRepository,
        private readonly RoomMemberRepository $roomMemberRepository,
    )
    {

    }

    public function execute(Input $input): void
    {
        $room = Room::restore($this->roomRepository->restore($input->roomId));
        $member = RoomMember::restore($this->roomMemberRepository->restore($input->memberId));
        if ($member->isStayedIn($room)) {
            return;
        }
        $member->enter($room);
        $member->save($this->roomMemberRepository);
    }
}
