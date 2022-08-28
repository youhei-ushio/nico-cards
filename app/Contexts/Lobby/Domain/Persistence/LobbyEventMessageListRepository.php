<?php

declare(strict_types=1);

namespace App\Contexts\Lobby\Domain\Persistence;

use App\Contexts\Core\Domain\Persistence\EventMessageListRepository;

interface LobbyEventMessageListRepository extends EventMessageListRepository
{
    /**
     * @return void
     */
    public function restore(): void;
}
