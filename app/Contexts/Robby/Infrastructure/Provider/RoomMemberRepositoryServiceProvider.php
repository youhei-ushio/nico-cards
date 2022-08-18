<?php

declare(strict_types=1);

namespace App\Contexts\Robby\Infrastructure\Provider;

use App\Contexts\Robby\Domain\Persistence\RoomMemberRepository;
use App\Contexts\Robby\Infrastructure\Persistence\RoomMemberRepositoryImpl;
use Illuminate\Support\ServiceProvider;

final class RoomMemberRepositoryServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind(RoomMemberRepository::class, RoomMemberRepositoryImpl::class);
    }
}
