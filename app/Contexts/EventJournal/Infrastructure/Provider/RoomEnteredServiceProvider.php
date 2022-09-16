<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\EventJournal\Domain\Notification\Room\Entered;
use App\Contexts\EventJournal\Infrastructure\Notification\Room\EnteredImpl;
use Illuminate\Support\ServiceProvider;

final class RoomEnteredServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(Entered::class, EnteredImpl::class);
    }
}
