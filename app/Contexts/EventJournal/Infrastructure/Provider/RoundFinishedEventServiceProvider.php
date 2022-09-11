<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\EventJournal\Domain\Event\Round\Finished;
use App\Contexts\EventJournal\Infrastructure\Event\Round\FinishedImpl;
use Illuminate\Support\ServiceProvider;

final class RoundFinishedEventServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(Finished::class, FinishedImpl::class);
    }
}
