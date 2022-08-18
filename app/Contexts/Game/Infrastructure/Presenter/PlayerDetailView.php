<?php

declare(strict_types=1);

namespace App\Contexts\Game\Infrastructure\Presenter;

use App\Contexts\Game\Domain\Value\Player;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

final class PlayerDetailView
{
    public function __construct(
        public readonly Player $self,
    )
    {

    }

    /**
     * @return Factory|View|Application
     */
    public function render(): Factory|View|Application
    {
        \Illuminate\Support\Facades\View::addNamespace(
            namespace: 'Game',
            hints: __DIR__ . '/templates');
        return view('Game::player/detail')->with('view', $this);
    }
}
