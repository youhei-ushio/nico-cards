<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\EventJournal\Domain\Notification\Round\CreatingCanceled;
use App\Contexts\EventJournal\Infrastructure\Notification\Round\CreatingCanceledImpl;
use Illuminate\Support\ServiceProvider;

final class RoundCreatingCanceledServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(CreatingCanceled::class, CreatingCanceledImpl::class);
    }
}
