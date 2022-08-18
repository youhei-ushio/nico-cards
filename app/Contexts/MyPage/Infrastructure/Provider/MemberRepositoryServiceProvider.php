<?php

declare(strict_types=1);

namespace App\Contexts\MyPage\Infrastructure\Provider;

use App\Contexts\MyPage\Domain\Persistence\MemberRepository;
use App\Contexts\MyPage\Infrastructure\Persistence\MemberRepositoryImpl;
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
