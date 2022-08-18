<?php

declare(strict_types=1);

namespace App\Contexts\Robby\Infrastructure\Provider;

use App\Contexts\Robby\Infrastructure\Persistence\RoomListRepositoryImpl;
use App\Core\Domain\Persistence\RoomListRepository;
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
