<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\EventJournal\Domain\Event\Room\Left;
use App\Contexts\EventJournal\Infrastructure\Event\Room\LeftImpl;
use Illuminate\Support\ServiceProvider;

final class RoomLeftEventServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(Left::class, LeftImpl::class);
    }
}
