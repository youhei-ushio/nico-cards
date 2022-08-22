<?php

declare(strict_types=1);

namespace App\Contexts\MyPage\UseCase\Profile\Update;

use App\Contexts\Core\Domain\Value;
use Seasalt\Nicoca\Components\UseCase\InputValidator;

final class Input
{
    public function __construct(
        public readonly Value\Member\Id $memberId,
        public readonly Value\Member\Name $memberName,
    )
    {

    }

    /**
     * POST値からインスタンスを作成する
     *
     * @param array $input
     * @return static
     */
    public static function fromArray(array $input): self
    {
        $validator = new InputValidator(
            requiredFields: [
                'member_id' => Value\Member\Id::class,
                'member_name' => Value\Member\Name::class,
            ],
            optionalFields: [

            ]);
        $validator->validate($input);

        return new self(
            $validator->getValidated('member_id'),
            $validator->getValidated('member_name'),
        );
    }
}
