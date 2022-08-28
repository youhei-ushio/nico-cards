<?php

declare(strict_types=1);

namespace App\Contexts\Lobby\Infrastructure\Http\Controller\Room;

use App\Contexts\Lobby\Infrastructure\Http\Request\Room\IndexRequest;
use App\Contexts\Lobby\Infrastructure\Presenter\RoomIndexView;
use App\Contexts\Lobby\UseCase\Room\Index\Input;
use App\Contexts\Lobby\UseCase\Room\Index\Interactor;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Spatie\RouteAttributes\Attributes\Get;

/**
 * 部屋一覧画面
 *
 * @noinspection PhpUnused
 */
final class IndexController extends Controller
{
    /**
     * @param IndexRequest $request
     * @param Interactor $interactor
     * @return Factory|View|Application
     */
    #[Get('/dashboard', 'dashboard')]
    public function __invoke(
        IndexRequest $request,
        Interactor $interactor,
    ): Factory|View|Application
    {
        $output = $interactor->execute(Input::fromArray($request->validated()));
        $view = new RoomIndexView(
            rooms: $output->rooms,
            member: $output->member,
            messages: $output->messages,
            lastEventId: $output->lastEventId,
        );
        return $view->render();
    }
}
