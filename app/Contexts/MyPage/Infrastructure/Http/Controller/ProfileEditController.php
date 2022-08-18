<?php

declare(strict_types=1);

namespace App\Contexts\MyPage\Infrastructure\Http\Controller;

use App\Contexts\MyPage\Infrastructure\Http\Request\ProfileEditRequest;
use App\Contexts\MyPage\Infrastructure\Presenter\ProfileEditView;
use App\Contexts\MyPage\UseCase\Profile\Edit\Input;
use App\Contexts\MyPage\UseCase\Profile\Edit\Interactor;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Spatie\RouteAttributes\Attributes\Get;

/**
 * @noinspection PhpUnused
 */
final class ProfileEditController extends Controller
{
    /**
     * @param ProfileEditRequest $request
     * @param Interactor $interactor
     * @return Factory|View|Application
     */
    #[Get('/my_page/profile', 'my_page.profile.edit')]
    public function __invoke(
        ProfileEditRequest $request,
        Interactor $interactor,
    ): Factory|View|Application
    {
        $output = $interactor->execute(Input::fromArray($request->validated()));
        $view = new ProfileEditView(
            $output->member,
        );
        return $view->render();
    }
}
