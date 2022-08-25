<?php

declare(strict_types=1);

namespace App\Contexts\Game\Infrastructure\Http\Controller\Round;

use App\Contexts\Core\Domain\Value;
use App\Contexts\Game\Infrastructure\Http\Request\Round\StartRequest;
use App\Contexts\Game\UseCase\Round\Start\Input;
use App\Contexts\Game\UseCase\Round\Start\Interactor;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Spatie\RouteAttributes\Attributes\Get;

/**
 * ゲーム開始
 *
 * @noinspection PhpUnused
 */
final class StartController extends Controller
{
    /**
     * @param StartRequest $request
     * @param Interactor $interactor
     * @return Application|RedirectResponse|Redirector
     */
    #[Get('/game/round/start', 'game.round.start')]
    public function __invoke(
        StartRequest $request,
        Interactor $interactor,
    ): Redirector|RedirectResponse|Application
    {
        $input = $request->validated();
        $interactor->execute(new Input(Value\Member\Id::fromNumber($input['member_id'])));
        return redirect()->back();
    }
}
