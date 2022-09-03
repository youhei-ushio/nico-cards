<?php

declare(strict_types=1);

namespace App\Contexts\Game\UseCase\Round\Play;

use App\Contexts\Core\Domain\Value;
use Seasalt\Nicoca\Components\UseCase\InputValidator;

final class Input
{
    /**
     * @param Value\Member\Id $memberId
     * @param Value\Game\Card[] $cards
     */
    public function __construct(
        public readonly Value\Member\Id $memberId,
        public readonly array $cards,
    )
    {

    }

    /**
     * POST値からインスタンスを作成する
     *
     * @param array $input
     * @return self
     */
    public static function fromArray(array $input): self
    {
        $validator = new InputValidator(
            requiredFields: [
                'member_id' => Value\Member\Id::class,
            ],
            optionalFields: [

            ]);
        $validator->validate($input);

        return new self(
            $validator->getValidated('member_id'),
            array_map(
                function (array $cardInput) {
                    return new Value\Game\Card(
                        $cardInput['suit'],
                        intval($cardInput['number']),
                    );
                }, $input['cards'] ?? []),
        );
    }
}
