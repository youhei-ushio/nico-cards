<?php

declare(strict_types=1);

namespace App\Contexts\Robby\UseCase\Room\Enter;

use App\Core\Domain\Value;
use Seasalt\Nicoca\Components\UseCase\InputValidator;

final class Input
{
    public function __construct(
        public readonly Value\Member\Id $memberId,
        public readonly Value\Room\Id $roomId,
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
                'room_id' => Value\Room\Id::class,
            ],
            optionalFields: [

            ]);
        $validator->validate($input);

        return new self(
            $validator->getValidated('member_id'),
            $validator->getValidated('room_id'),
        );
    }
}
