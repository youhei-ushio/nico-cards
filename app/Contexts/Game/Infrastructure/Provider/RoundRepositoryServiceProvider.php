<?php

declare(strict_types=1);

namespace App\Contexts\Game\Infrastructure\Provider;

use App\Contexts\Game\Domain\Persistence\RoundRepository;
use App\Contexts\Game\Infrastructure\Persistence\RoundRepositoryImpl;
use Illuminate\Support\ServiceProvider;

final class RoundRepositoryServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(RoundRepository::class, RoundRepositoryImpl::class);
    }
}
