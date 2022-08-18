<?php

declare(strict_types=1);

namespace App\Contexts\Robby\Infrastructure\Provider;

use App\Contexts\Robby\Infrastructure\Persistence\MemberRepositoryImpl;
use App\Core\Domain\Persistence\MemberRepository;
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
