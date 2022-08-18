<?php

declare(strict_types=1);

namespace App\Contexts\Robby\UseCase\Room\Index;

use App\Core\Domain\Persistence\MemberRepository;
use App\Core\Domain\Persistence\RoomListRepository;
use App\Core\Domain\Value\Member;
use App\Core\Domain\Value\Room;

final class Interactor
{
    public function __construct(
        private readonly RoomListRepository $roomListRepository,
        private readonly MemberRepository $memberRepository,
    )
    {

    }

    public function execute(Input $input): Output
    {
        $this->roomListRepository->restore();
        $rooms = Room::restoreList($this->roomListRepository);
        $member = Member::restore($this->memberRepository->restore($input->memberId));
        return new Output($rooms, $member);
    }
}
