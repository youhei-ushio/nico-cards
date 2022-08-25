<?php

declare(strict_types=1);

namespace App\Contexts\Lobby\Infrastructure\Http\Controller\Room;

use App\Contexts\Lobby\Domain\Event\Left;
use App\Contexts\Lobby\Infrastructure\Http\Request\Room\LeaveRequest;
use App\Contexts\Core\Domain\Persistence\EventRepository;
use App\Contexts\Core\Domain\Value;
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
     * @param EventRepository $repository
     * @return Application|RedirectResponse|Redirector
     */
    #[Get('/lobby/rooms/{id}/leave', 'lobby.rooms.leave')]
    public function __invoke(
        LeaveRequest $request,
        EventRepository $repository,
    ): Redirector|RedirectResponse|Application
    {
        $input = $request->validated();
        $event = new Left(
            Value\Member\Id::fromNumber($input['member_id']),
            Value\Room\Id::fromString($input['room_id']),
        );
        $event->save($repository);
        $repository->waitForLastEvent();
        return redirect(route('dashboard'));
    }
}
