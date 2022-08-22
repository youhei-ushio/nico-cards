<?php

declare(strict_types=1);

namespace App\Contexts\MyPage\Infrastructure\Presenter;

use App\Contexts\Core\Domain\Value\Member;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

final class ProfileEditView
{
    public function __construct(
        public readonly Member $member,
    )
    {

    }

    /**
     * @return Factory|View|Application
     */
    public function render(): Factory|View|Application
    {
        \Illuminate\Support\Facades\View::addNamespace(
            namespace: 'MyPage',
            hints: __DIR__ . '/templates');
        return view('MyPage::profile/edit')->with('view', $this);
    }
}
