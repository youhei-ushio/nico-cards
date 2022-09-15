<?php

declare(strict_types=1);

namespace App\Contexts\Lobby\Infrastructure\Http\Controller\Room;

use App\Contexts\Lobby\Infrastructure\Http\Request\Room\LeaveRequest;
use App\Contexts\Lobby\UseCase\Room\Leave\Input;
use App\Contexts\Lobby\UseCase\Room\Leave\Interactor;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Spatie\RouteAttributes\Attributes\Get;

/**
 * 部屋退室
 *
 * @noinspection PhpUnused
 */
final class LeaveController extends Controller
{
    /**
     * @param LeaveRequest $request
     * @param Interactor $interactor
     * @return void
     */
    #[Get('/lobby/rooms/{id}/leave', 'lobby.rooms.leave')]
    public function __invoke(
        LeaveRequest $request,
        Interactor $interactor,
    ): void
    {
        $input = $request->validated();
        $interactor->execute(Input::fromArray($input));
    }
}
