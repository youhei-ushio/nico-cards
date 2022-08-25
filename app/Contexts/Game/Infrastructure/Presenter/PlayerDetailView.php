<?php

declare(strict_types=1);

namespace App\Contexts\Game\Infrastructure\Presenter;

use App\Contexts\Core\Domain\Value;
use App\Contexts\Game\Domain\Value\Round;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

final class PlayerDetailView
{
    public function __construct(
        public readonly Value\Member $member,
        public readonly Value\Room $room,
        public readonly Round|null $round,
        public readonly Value\Event\MessageCollection $messages,
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

    /**
     * @param int $index
     * @return string
     */
    public function getPlayerImagePath(Value\Member\Id $memberId): string
    {
        $index = $memberId->getValue() % 4;
        return match ($index) {
            1 => asset('/images/youngwoman_45.png'),
            2 => asset('/images/youngman_33.png'),
            3 => asset('/images/youngwoman_38.png'),
            default => asset('/images/youngman_29.png'),
        };
    }

    /**
     * @param Value\Game\Card $card
     * @return string
     */
    public function getCardImagePath(Value\Game\Card $card): string
    {
        if ($card->isJoker()) {
            return asset('/images/card_joker.png');
        }
        $suit = strtolower(Str::singular($card->suit));
        return asset(sprintf('/images/card_%s_%02d.png', $suit, $card->number));
    }
}
