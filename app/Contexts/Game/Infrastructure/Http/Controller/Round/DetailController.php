<?php

declare(strict_types=1);

namespace App\Contexts\Game\Infrastructure\Http\Controller\Round;

use App\Contexts\Game\Domain\Exception\RoomNotFoundException;
use App\Contexts\Game\Domain\Exception\RoundNotFoundException;
use App\Contexts\Game\Infrastructure\Http\Request\Round\DetailRequest;
use App\Contexts\Game\Infrastructure\Presenter\PlayerDetailView;
use App\Contexts\Game\UseCase\Round\Detail\Input;
use App\Contexts\Game\UseCase\Round\Detail\Interactor;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Spatie\RouteAttributes\Attributes\Get;

/**
 * ゲーム画面
 *
 * @noinspection PhpUnused
 */
final class DetailController extends Controller
{
    /**
     * @param DetailRequest $request
     * @param Interactor $interactor
     * @return View|Factory|Redirector|Application|RedirectResponse
     */
    #[Get('/game/round', 'game.round.detail')]
    public function __invoke(
        DetailRequest $request,
        Interactor $interactor,
    ): View|Factory|Redirector|Application|RedirectResponse {
        try {
            $output = $interactor->execute(Input::fromArray($request->validated()));
        } catch (RoomNotFoundException|RoundNotFoundException) {
            return redirect(route('dashboard'));
        }
        $view = new PlayerDetailView(
            $output->member,
            $output->room,
            $output->round,
            $output->messages,
            $output->lastEventId,
        );
        return $view->render();
    }
}
