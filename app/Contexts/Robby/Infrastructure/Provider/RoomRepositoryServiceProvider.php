<?php

declare(strict_types=1);

namespace App\Contexts\Robby\Infrastructure\Provider;

use App\Contexts\Robby\Infrastructure\Persistence\RoomRepositoryImpl;
use App\Core\Domain\Persistence\RoomRepository;
use Illuminate\Support\ServiceProvider;

final class RoomRepositoryServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind(RoomRepository::class, RoomRepositoryImpl::class);
    }
}
