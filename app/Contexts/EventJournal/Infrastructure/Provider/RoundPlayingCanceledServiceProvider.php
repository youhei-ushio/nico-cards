<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\EventJournal\Domain\Notification\Round\PlayingCanceled;
use App\Contexts\EventJournal\Infrastructure\Notification\Round\PlayingCanceledImpl;
use Illuminate\Support\ServiceProvider;

final class RoundPlayingCanceledServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(PlayingCanceled::class, PlayingCanceledImpl::class);
    }
}
