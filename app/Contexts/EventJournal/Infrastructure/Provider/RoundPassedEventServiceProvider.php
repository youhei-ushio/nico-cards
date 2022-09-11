<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\EventJournal\Domain\Event\Round\Passed;
use App\Contexts\EventJournal\Infrastructure\Event\Round\PassedImpl;
use Illuminate\Support\ServiceProvider;

final class RoundPassedEventServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(Passed::class, PassedImpl::class);
    }
}
