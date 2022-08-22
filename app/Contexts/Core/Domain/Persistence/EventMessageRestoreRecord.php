<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Persistence;

use App\Contexts\Core\Domain\Value;

/**
 * リポジトリで利用するDTO
 *
 * @see EventMessageListRepository::restore
 */
final class EventMessageRestoreRecord
{
    public function __construct(
        public readonly Value\Event\Id $id,
        public readonly Value\Event\OccurredDateTime $occurredAt,
        public readonly Value\Event\Message\Body $body,
        public readonly Value\Event\Message\Level $level,
    )
    {

    }
}
