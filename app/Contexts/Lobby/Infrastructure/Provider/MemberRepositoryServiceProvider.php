<?php

declare(strict_types=1);

namespace App\Contexts\Lobby\Infrastructure\Provider;

use App\Contexts\Lobby\Infrastructure\Persistence\MemberRepositoryImpl;
use App\Contexts\Core\Domain\Persistence\MemberRepository;
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
