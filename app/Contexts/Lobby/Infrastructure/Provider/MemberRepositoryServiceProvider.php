<?php

declare(strict_types=1);

namespace App\Contexts\Lobby\Infrastructure\Provider;

use App\Contexts\Lobby\Domain\Persistence\MemberRepository;
use App\Contexts\Lobby\Infrastructure\Persistence\MemberRepositoryImpl;
use Illuminate\Support\ServiceProvider;

final class MemberRepositoryServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind(MemberRepository::class, MemberRepositoryImpl::class);
    }
}
