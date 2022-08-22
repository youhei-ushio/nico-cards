<?php

declare(strict_types=1);

namespace App\Contexts\Game\UseCase\Player\Detail;

use App\Contexts\Core\Domain\Value\Room;
use App\Contexts\Game\Domain\Persistence\RoomRepository;
use App\Contexts\Game\Domain\Value\Player;
use App\Contexts\Game\Domain\Persistence\PlayerRepository;

final class Interactor
{
    public function __construct(
        private readonly PlayerRepository $playerRepository,
        private readonly RoomRepository $roomRepository,
    )
    {

    }

    public function execute(Input $input): Output
    {
        $self = Player::restore($this->playerRepository->restore($input->memberId));
        $room = Room::restore($this->roomRepository->restore($input->memberId));
        return new Output($self, $room);
    }
}
