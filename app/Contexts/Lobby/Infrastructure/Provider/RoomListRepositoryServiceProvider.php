<?php

declare(strict_types=1);

namespace App\Contexts\Lobby\Infrastructure\Provider;

use App\Contexts\Lobby\Infrastructure\Persistence\RoomListRepositoryImpl;
use App\Contexts\Core\Domain\Persistence\RoomListRepository;
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
