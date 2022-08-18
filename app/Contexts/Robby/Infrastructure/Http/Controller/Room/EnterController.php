<?php

declare(strict_types=1);

namespace App\Contexts\Robby\Infrastructure\Http\Controller\Room;

use App\Contexts\Robby\Domain\Exception\CannotEnterRoomException;
use App\Contexts\Robby\Infrastructure\Http\Request\Room\EnterRequest;
use App\Contexts\Robby\UseCase\Room\Enter\Input;
use App\Contexts\Robby\UseCase\Room\Enter\Interactor;
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
    #[Get('/robby/rooms/{id}/enter', 'robby.rooms.enter')]
    public function __invoke(
        EnterRequest $request,
        Interactor $interactor,
    ): Redirector|RedirectResponse|Application
    {
        try {
            $interactor->execute(Input::fromArray($request->validated()));
        } catch (CannotEnterRoomException) {
            return redirect(route('dashboard'));
        }
        return redirect(route('game.player.detail'));
    }
}
