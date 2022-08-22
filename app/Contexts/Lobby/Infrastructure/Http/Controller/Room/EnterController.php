<?php

declare(strict_types=1);

namespace App\Contexts\Lobby\Infrastructure\Http\Controller\Room;

use App\Contexts\Lobby\Domain\Event\Entered;
use App\Contexts\Lobby\Infrastructure\Http\Request\Room\EnterRequest;
use App\Contexts\Core\Domain\Persistence\EventRepository;
use App\Contexts\Core\Domain\Value;
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
     * @param EventRepository $repository
     * @return Application|RedirectResponse|Redirector
     */
    #[Get('/lobby/rooms/{id}/enter', 'lobby.rooms.enter')]
    public function __invoke(
        EnterRequest $request,
        EventRepository $repository,
    ): Redirector|RedirectResponse|Application
    {
        $input = $request->validated();
        $event = new Entered(
            Value\Member\Id::fromNumber($input['member_id']),
            Value\Room\Id::fromString($input['room_id']),
        );
        $event->save($repository);
        return redirect(route('dashboard'));
    }
}
