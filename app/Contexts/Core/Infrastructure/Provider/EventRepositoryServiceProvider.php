<?php

declare(strict_types=1);

namespace App\Contexts\Core\Infrastructure\Provider;

use App\Contexts\Core\Domain\Persistence\EventRepository;
use App\Contexts\Core\Infrastructure\Persistence\EventRepositoryImpl;
use Illuminate\Support\ServiceProvider;

final class EventRepositoryServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind(EventRepository::class, EventRepositoryImpl::class);
    }
}
