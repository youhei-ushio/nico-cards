<?php

declare(strict_types=1);

namespace App\Contexts\Robby\UseCase\Room\Leave;

use App\Contexts\Robby\Domain\Entity\RoomMember;
use App\Contexts\Robby\Domain\Persistence\RoomMemberRepository;

final class Interactor
{
    public function __construct(
        private readonly RoomMemberRepository $roomMemberRepository,
    )
    {

    }

    public function execute(Input $input): void
    {
        $member = RoomMember::restore($this->roomMemberRepository->restore($input->memberId));
        $member->leave();
        $member->save($this->roomMemberRepository);
    }
}
