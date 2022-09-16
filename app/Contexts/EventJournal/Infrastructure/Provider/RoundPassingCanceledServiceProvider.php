<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\EventJournal\Domain\Notification\Round\PassingCanceled;
use App\Contexts\EventJournal\Infrastructure\Notification\Round\PassingCanceledImpl;
use Illuminate\Support\ServiceProvider;

final class RoundPassingCanceledServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(PassingCanceled::class, PassingCanceledImpl::class);
    }
}
