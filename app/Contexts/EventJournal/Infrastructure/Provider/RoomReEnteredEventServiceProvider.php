<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\EventJournal\Domain\Event\Room\ReEntered;
use App\Contexts\EventJournal\Infrastructure\Event\Room\ReEnteredImpl;
use Illuminate\Support\ServiceProvider;

final class RoomReEnteredEventServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(ReEntered::class, ReEnteredImpl::class);
    }
}
