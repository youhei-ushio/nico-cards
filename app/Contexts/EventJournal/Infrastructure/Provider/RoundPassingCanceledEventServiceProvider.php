<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\EventJournal\Domain\Event\Round\PassingCanceled;
use App\Contexts\EventJournal\Infrastructure\Event\Round\PassingCanceledImpl;
use Illuminate\Support\ServiceProvider;

final class RoundPassingCanceledEventServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(PassingCanceled::class, PassingCanceledImpl::class);
    }
}
