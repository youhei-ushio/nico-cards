<?php

declare(strict_types=1);

namespace App\Contexts\Game\Infrastructure\Provider;

use App\Contexts\Game\Domain\Persistence\RoomRepository;
use App\Contexts\Game\Infrastructure\Persistence\RoomRepositoryImpl;
use Illuminate\Support\ServiceProvider;

final class RoomRepositoryServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(RoomRepository::class, RoomRepositoryImpl::class);
    }
}
