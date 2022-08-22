<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\Core\Domain\Persistence\RoomRepository;
use App\Contexts\EventJournal\Infrastructure\Persistence\RoomRepositoryImpl;
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
