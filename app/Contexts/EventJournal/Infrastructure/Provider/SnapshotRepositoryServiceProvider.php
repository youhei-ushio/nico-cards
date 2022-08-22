<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\EventJournal\Domain\Persistence\SnapshotRepository;
use App\Contexts\EventJournal\Infrastructure\Persistence\SnapshotRepositoryImpl;
use Illuminate\Support\ServiceProvider;

final class SnapshotRepositoryServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind(SnapshotRepository::class, SnapshotRepositoryImpl::class);
    }
}
