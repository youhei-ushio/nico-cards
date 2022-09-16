<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\EventJournal\Domain\Notification\Round\Started;
use App\Contexts\EventJournal\Infrastructure\Notification\Round\StartedImpl;
use Illuminate\Support\ServiceProvider;

final class RoundStartedServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(Started::class, StartedImpl::class);
    }
}
