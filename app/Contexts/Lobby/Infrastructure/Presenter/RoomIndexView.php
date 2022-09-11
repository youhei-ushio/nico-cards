<?php

declare(strict_types=1);

namespace App\Contexts\Lobby\Infrastructure\Presenter;

use App\Contexts\Core\Domain\Value;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

final class RoomIndexView
{
    public function __construct(
        public readonly Value\RoomCollection $rooms,
        public readonly Value\Member $member,
    )
    {

    }

    /**
     * @return Factory|View|Application
     */
    public function render(): Factory|View|Application
    {
        \Illuminate\Support\Facades\View::addNamespace(
            namespace: 'Lobby',
            hints: __DIR__ . '/templates');
        return view('Lobby::room/index')->with('view', $this);
    }
}
