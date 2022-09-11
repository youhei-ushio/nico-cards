<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Provider;

use App\Contexts\EventJournal\Domain\Persistence\RoomMemberRepository;
use App\Contexts\EventJournal\Infrastructure\Persistence\RoomMemberRepositoryImpl;
use Illuminate\Support\ServiceProvider;

final class RoomMemberRepositoryServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(RoomMemberRepository::class, RoomMemberRepositoryImpl::class);
    }
}
