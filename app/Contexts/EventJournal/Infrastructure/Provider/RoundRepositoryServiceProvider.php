<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\EventJournal\Domain\Persistence\RoundRepository;
use App\Contexts\EventJournal\Infrastructure\Persistence\RoundRepositoryImpl;
use Illuminate\Support\ServiceProvider;

final class RoundRepositoryServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind(RoundRepository::class, RoundRepositoryImpl::class);
    }
}
