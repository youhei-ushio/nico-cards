<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\EventJournal\Domain\Persistence\JournalListRepository;
use App\Contexts\EventJournal\Infrastructure\Persistence\JournalListRepositoryImpl;
use Illuminate\Support\ServiceProvider;

final class JournalListRepositoryServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(JournalListRepository::class, JournalListRepositoryImpl::class);
    }
}
