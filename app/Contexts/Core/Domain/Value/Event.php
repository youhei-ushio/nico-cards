<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Value;

use App\Contexts\Core\Domain\Persistence\EventRepository;

interface Event
{
    public function save(EventRepository $repository): void;
}
