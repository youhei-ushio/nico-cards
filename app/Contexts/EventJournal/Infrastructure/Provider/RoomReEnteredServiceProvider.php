<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\EventJournal\Domain\Notification\Room\ReEntered;
use App\Contexts\EventJournal\Infrastructure\Notification\Room\ReEnteredImpl;
use Illuminate\Support\ServiceProvider;

final class RoomReEnteredServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(ReEntered::class, ReEnteredImpl::class);
    }
}
