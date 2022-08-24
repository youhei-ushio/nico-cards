<?php

declare(strict_types=1);

namespace App\Contexts\Lobby\Infrastructure\Provider;

use App\Contexts\Lobby\Domain\Persistence\RoomListRepository;
use App\Contexts\Lobby\Infrastructure\Persistence\RoomListRepositoryImpl;
use Illuminate\Support\ServiceProvider;

final class RoomListRepositoryServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind(RoomListRepository::class, RoomListRepositoryImpl::class);
    }
}
