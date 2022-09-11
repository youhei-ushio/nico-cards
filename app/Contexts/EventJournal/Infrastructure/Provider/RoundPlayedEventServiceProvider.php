<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\EventJournal\Domain\Event\Round\Played;
use App\Contexts\EventJournal\Infrastructure\Event\Round\PlayedImpl;
use Illuminate\Support\ServiceProvider;

final class RoundPlayedEventServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(Played::class, PlayedImpl::class);
    }
}
