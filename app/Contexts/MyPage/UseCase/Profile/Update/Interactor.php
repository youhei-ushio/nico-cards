<?php

declare(strict_types=1);

namespace App\Contexts\MyPage\UseCase\Profile\Update;

use App\Contexts\MyPage\Domain\Entity\Member;
use App\Contexts\MyPage\Domain\Persistence\MemberRepository;

final class Interactor
{
    public function __construct(
        private readonly MemberRepository $memberRepository,
    )
    {

    }

    public function execute(Input $input): void
    {
        $member = Member::restore($this->memberRepository->restore($input->memberId));
        $member->rename($input->memberName);
        $member->save($this->memberRepository);
    }
}
