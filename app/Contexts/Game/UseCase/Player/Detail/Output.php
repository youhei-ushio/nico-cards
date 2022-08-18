<?php

declare(strict_types=1);

namespace App\Contexts\Game\UseCase\Player\Detail;

use App\Contexts\Game\Domain\Value\Player;

final class Output
{
    public function __construct(
        public readonly Player $self,
    )
    {

    }
}
