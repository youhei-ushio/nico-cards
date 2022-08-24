<?php

declare(strict_types=1);

namespace App\Contexts\Game\Infrastructure\Http\Controller\Round;

use App\Contexts\Game\Infrastructure\Http\Request\Round\PlayRequest;
use App\Contexts\Game\UseCase\Round\Play\Input;
use App\Contexts\Game\UseCase\Round\Play\Interactor;
use App\Http\Controllers\Controller;
use Spatie\RouteAttributes\Attributes\Post;

/**
 * カードプレイ
 *
 * @noinspection PhpUnused
 */
final class PlayController extends Controller
{
    /**
     * @param PlayRequest $request
     * @param Interactor $interactor
     * @return void
     */
    #[Post('/game/round/play', 'game.round.play')]
    public function __invoke(
        PlayRequest $request,
        Interactor $interactor,
    ): void
    {
        $interactor->execute(Input::fromArray($request->validated()));
    }
}
