<?php

declare(strict_types=1);

namespace App\Contexts\Game\Infrastructure\Provider;

use App\Contexts\Game\Domain\Persistence\PlayerRepository;
use App\Contexts\Game\Infrastructure\Persistence\PlayerRepositoryImpl;
use Illuminate\Support\ServiceProvider;

final class PlayerRepositoryServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(PlayerRepository::class, PlayerRepositoryImpl::class);
    }
}
