<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Persistence;

use App\Contexts\Core\Domain\Value;
use JsonSerializable;

final class EventSaveRecord
{
    public function __construct(
        public readonly Value\Event\Type $type,
        public readonly Value\Member\Id $memberId,
        public readonly Value\Room\Id $roomId,
        public readonly JsonSerializable|array|null $payload,
    )
    {

    }
}
