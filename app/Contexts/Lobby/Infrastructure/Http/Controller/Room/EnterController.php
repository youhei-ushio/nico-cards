<?php

declare(strict_types=1);

namespace App\Contexts\Lobby\Infrastructure\Http\Controller\Room;

use App\Contexts\Lobby\Infrastructure\Http\Request\Room\EnterRequest;
use App\Contexts\Lobby\UseCase\Room\Enter\Input;
use App\Contexts\Lobby\UseCase\Room\Enter\Interactor;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Spatie\RouteAttributes\Attributes\Get;

/**
 * 部屋入室
 *
 * @noinspection PhpUnused
 */
final class EnterController extends Controller
{
    /**
     * @param EnterRequest $request
     * @param Interactor $interactor
     * @return Application|RedirectResponse|Redirector
     */
    #[Get('/lobby/rooms/{id}/enter', 'lobby.rooms.enter')]
    public function __invoke(
        EnterRequest $request,
        Interactor $interactor,
    ): Redirector|RedirectResponse|Application
    {
        $input = $request->validated();
        $interactor->execute(Input::fromArray($input));
        return redirect(route('game.round.detail') . '?member_id=' . $input['member_id']);
    }
}
