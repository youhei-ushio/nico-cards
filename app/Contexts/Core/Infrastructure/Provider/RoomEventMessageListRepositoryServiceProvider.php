<?php

declare(strict_types=1);

namespace App\Contexts\Core\Infrastructure\Provider;

use App\Contexts\Core\Domain\Persistence\RoomEventMessageListRepository;
use App\Contexts\Core\Infrastructure\Persistence\RoomEventMessageListRepositoryImpl;
use Illuminate\Support\ServiceProvider;

final class RoomEventMessageListRepositoryServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind(RoomEventMessageListRepository::class, RoomEventMessageListRepositoryImpl::class);
    }
}
