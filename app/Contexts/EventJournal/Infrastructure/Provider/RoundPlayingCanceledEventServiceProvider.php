<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\EventJournal\Domain\Event\Round\PlayingCanceled;
use App\Contexts\EventJournal\Infrastructure\Event\Round\PlayingCanceledImpl;
use Illuminate\Support\ServiceProvider;

final class RoundPlayingCanceledEventServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(PlayingCanceled::class, PlayingCanceledImpl::class);
    }
}
