<?php

declare(strict_types=1);

namespace App\Contexts\Robby\Infrastructure\Presenter;

use App\Core\Domain\Value\Member;
use App\Core\Domain\Value\RoomCollection;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

final class RoomIndexView
{
    public function __construct(
        public readonly RoomCollection $rooms,
        public readonly Member $member,
    )
    {

    }

    /**
     * @return Factory|View|Application
     */
    public function render(): Factory|View|Application
    {
        \Illuminate\Support\Facades\View::addNamespace(
            namespace: 'Robby',
            hints: __DIR__ . '/templates');
        return view('Robby::room/index')->with('view', $this);
    }
}
