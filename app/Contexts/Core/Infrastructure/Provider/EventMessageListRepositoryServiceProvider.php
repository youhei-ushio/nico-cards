<?php

declare(strict_types=1);

namespace App\Contexts\Core\Infrastructure\Provider;

use App\Contexts\Core\Domain\Persistence\EventMessageListRepository;
use App\Contexts\Core\Infrastructure\Persistence\EventMessageListRepositoryImpl;
use Illuminate\Support\ServiceProvider;

final class EventMessageListRepositoryServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind(EventMessageListRepository::class, EventMessageListRepositoryImpl::class);
    }
}
