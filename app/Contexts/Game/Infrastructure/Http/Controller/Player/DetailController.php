<?php

declare(strict_types=1);

namespace App\Contexts\Game\Infrastructure\Http\Controller\Player;

use App\Contexts\Game\Domain\Exception\PlayerNotFoundException;
use App\Contexts\Game\Infrastructure\Http\Request\Player\DetailRequest;
use App\Contexts\Game\Infrastructure\Presenter\PlayerDetailView;
use App\Contexts\Game\UseCase\Player\Detail\Input;
use App\Contexts\Game\UseCase\Player\Detail\Interactor;
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
    #[Get('/game/player', 'game.player.detail')]
    public function __invoke(
        DetailRequest $request,
        Interactor $interactor,
    ): View|Factory|Redirector|Application|RedirectResponse {
        try {
            $output = $interactor->execute(Input::fromArray($request->validated()));
        } catch (PlayerNotFoundException) {
            return redirect(route('dashboard'));
        }
        $view = new PlayerDetailView(
            $output->self,
        );
        return $view->render();
    }
}
