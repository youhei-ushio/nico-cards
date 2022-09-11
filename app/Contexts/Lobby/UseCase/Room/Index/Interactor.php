<?php

declare(strict_types=1);

namespace App\Contexts\Lobby\UseCase\Room\Index;

use App\Contexts\Core\Domain\Value;
use App\Contexts\Lobby\Domain\Persistence\MemberRepository;
use App\Contexts\Lobby\Domain\Persistence\RoomListRepository;

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
        $rooms = Value\Room::restoreList($this->roomListRepository);
        $member = Value\Member::restore($this->memberRepository->restore($input->memberId));
        return new Output(
            $rooms,
            $member,
        );
    }
}
