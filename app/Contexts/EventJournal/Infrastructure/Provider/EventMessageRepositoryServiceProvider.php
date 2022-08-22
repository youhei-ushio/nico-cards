<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\EventJournal\Domain\Persistence\EventMessageRepository;
use App\Contexts\EventJournal\Infrastructure\Persistence\EventMessageRepositoryImpl;
use Illuminate\Support\ServiceProvider;

final class EventMessageRepositoryServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind(EventMessageRepository::class, EventMessageRepositoryImpl::class);
    }
}
