<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\EventJournal\Domain\Notification\Room\Left;
use App\Contexts\EventJournal\Infrastructure\Notification\Room\LeftImpl;
use Illuminate\Support\ServiceProvider;

final class RoomLeftServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(Left::class, LeftImpl::class);
    }
}
