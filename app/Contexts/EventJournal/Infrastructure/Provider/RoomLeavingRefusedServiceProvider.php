<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\EventJournal\Domain\Notification\Room\LeavingRefused;
use App\Contexts\EventJournal\Infrastructure\Notification\Room\LeavingRefusedImpl;
use Illuminate\Support\ServiceProvider;

final class RoomLeavingRefusedServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(LeavingRefused::class, LeavingRefusedImpl::class);
    }
}
