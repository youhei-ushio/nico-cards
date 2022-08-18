<?php

declare(strict_types=1);

namespace App\Contexts\MyPage\UseCase\Profile\Edit;

use App\Core\Domain\Value\Member;
use App\Core\Domain\Persistence\MemberRepository;

final class Interactor
{
    public function __construct(
        private readonly MemberRepository $memberRepository,
    )
    {

    }

    public function execute(Input $input): Output
    {
        $member = Member::restore($this->memberRepository->restore($input->memberId));
        return new Output($member);
    }
}