<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\EventJournal\Domain\Event\Room\Entered;
use App\Contexts\EventJournal\Infrastructure\Event\Room\EnteredImpl;
use Illuminate\Support\ServiceProvider;

final class RoomEnteredEventServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(Entered::class, EnteredImpl::class);
    }
}
