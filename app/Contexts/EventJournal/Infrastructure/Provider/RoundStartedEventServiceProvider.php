<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\EventJournal\Domain\Event\Round\Started;
use App\Contexts\EventJournal\Infrastructure\Event\Round\StartedImpl;
use Illuminate\Support\ServiceProvider;

final class RoundStartedEventServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(Started::class, StartedImpl::class);
    }
}
