<?php

declare(strict_types=1);

namespace App\Contexts\Lobby\Infrastructure\Provider;

use App\Contexts\Lobby\Domain\Persistence\LobbyEventMessageListRepository;
use App\Contexts\Lobby\Infrastructure\Persistence\LobbyEventMessageListRepositoryImpl;
use Illuminate\Support\ServiceProvider;

final class LobbyEventMessageListRepositoryServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind(LobbyEventMessageListRepository::class, LobbyEventMessageListRepositoryImpl::class);
    }
}
