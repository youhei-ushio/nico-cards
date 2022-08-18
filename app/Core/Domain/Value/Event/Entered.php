<?php

declare(strict_types=1);

namespace App\Core\Domain\Event;

use App\Core\Domain\Persistence\EventRepository;
use App\Core\Domain\Value\Event;

final class Entered implements Event
{
    public function save(EventRepository $repository): void
    {

    }
}
