<?php

declare(strict_types=1);

namespace App\Contexts\MyPage\UseCase\Profile\Edit;

use App\Core\Domain\Value\Member;

final class Output
{
    public function __construct(
        public readonly Member $member,
    )
    {

    }
}
