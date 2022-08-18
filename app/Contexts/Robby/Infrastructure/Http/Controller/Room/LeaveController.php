<?php

declare(strict_types=1);

namespace App\Contexts\Robby\Infrastructure\Http\Controller\Room;

use App\Contexts\Robby\Infrastructure\Http\Request\Room\LeaveRequest;
use App\Contexts\Robby\UseCase\Room\Leave\Input;
use App\Contexts\Robby\UseCase\Room\Leave\Interactor;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Spatie\RouteAttributes\Attributes\Get;

/**
 * 退室
 *
 * @noinspection PhpUnused
 */
final class LeaveController extends Controller
{
    /**
     * @param LeaveRequest $request
     * @param Interactor $interactor
     * @return Application|RedirectResponse|Redirector
     */
    #[Get('/robby/rooms/leave', 'robby.rooms.leave')]
    public function __invoke(
        LeaveRequest $request,
        Interactor $interactor,
    ): Redirector|RedirectResponse|Application
    {
        $interactor->execute(Input::fromArray($request->validated()));
        return redirect(route('dashboard'));
    }
}
