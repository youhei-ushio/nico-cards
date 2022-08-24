<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\EventJournal\Infrastructure\Persistence\RoomRepositoryImpl;
use App\Contexts\EventJournal\Domain\Persistence\RoomRepository;
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
