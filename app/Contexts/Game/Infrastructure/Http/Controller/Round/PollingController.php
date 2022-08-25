<?php

declare(strict_types=1);

namespace App\Contexts\Game\Infrastructure\Http\Controller\Round;

use App\Contexts\Core\Domain\Persistence\EventRepository;
use App\Contexts\Core\Domain\Value;
use App\Contexts\Game\Infrastructure\Http\Request\Round\PollingRequest;
use App\Http\Controllers\Controller;
use Spatie\RouteAttributes\Attributes\Get;

/**
 * ゲームイベントポーリング
 *
 * @noinspection PhpUnused
 */
final class PollingController extends Controller
{
    /**
     * @param PollingRequest $request
     * @param EventRepository $eventRepository
     * @return bool
     */
    #[Get('/game/round/polling', 'game.round.polling')]
    public function __invoke(
        PollingRequest $request,
        EventRepository $eventRepository,
    ): bool
    {
        $input = $request->validated();
        if (empty($input['last_event_id'])) {
            return false;
        }
        return $eventRepository->proceeded(Value\Event\Id::fromString($input['last_event_id']));
    }
}
