<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\EventJournal\Domain\Event\Room\EnteringRefused;
use App\Contexts\EventJournal\Infrastructure\Event\Room\EnteringRefusedImpl;
use Illuminate\Support\ServiceProvider;

final class RoomEnteringRefusedEventServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(EnteringRefused::class, EnteringRefusedImpl::class);
    }
}
