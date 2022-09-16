<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\EventJournal\Domain\Notification\Round\Played;
use App\Contexts\EventJournal\Infrastructure\Notification\Round\PlayedImpl;
use Illuminate\Support\ServiceProvider;

final class RoundPlayedServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(Played::class, PlayedImpl::class);
    }
}
