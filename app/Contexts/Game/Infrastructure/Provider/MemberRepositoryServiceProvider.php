<?php

declare(strict_types=1);

namespace App\Contexts\Game\Infrastructure\Provider;

use App\Contexts\Game\Domain\Persistence\MemberRepository;
use App\Contexts\Game\Infrastructure\Persistence\MemberRepositoryImpl;
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
