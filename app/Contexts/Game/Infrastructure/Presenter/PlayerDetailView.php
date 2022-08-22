<?php

declare(strict_types=1);

namespace App\Contexts\Game\Infrastructure\Presenter;

use App\Contexts\Core\Domain\Value\Room;
use App\Contexts\Game\Domain\Value\Player;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

final class PlayerDetailView
{
    public function __construct(
        public readonly Player $self,
        public readonly Room $room,
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

    public function getPlayerImagePath(int $index): string
    {
        switch ($index) {
            case 1:
                return asset('/images/youngwoman_45.png');
            case 2:
                return asset('/images/youngman_33.png');
            case 3:
                return asset('/images/youngwoman_38.png');
            default:
                return asset('/images/youngman_29.png');
        }
    }
}
