<?php

declare(strict_types=1);

namespace App\Contexts\MyPage\Infrastructure\Http\Controller;

use App\Contexts\MyPage\Infrastructure\Http\Request\ProfileUpdateRequest;
use App\Contexts\MyPage\UseCase\Profile\Update\Input;
use App\Contexts\MyPage\UseCase\Profile\Update\Interactor;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Spatie\RouteAttributes\Attributes\Post;

/**
 * @noinspection PhpUnused
 */
final class ProfileUpdateController extends Controller
{
    /**
     * @param ProfileUpdateRequest $request
     * @param Interactor $interactor
     * @return Redirector|Application|RedirectResponse
     */
    #[Post('/my_page/profile', 'my_page.profile.update')]
    public function __invoke(
        ProfileUpdateRequest $request,
        Interactor $interactor,
    ): Redirector|Application|RedirectResponse
    {
        $interactor->execute(Input::fromArray($request->validated()));
        return redirect(route('dashboard'));
    }
}
