<?php

declare(strict_types=1);

namespace App\Contexts\Game\Infrastructure\Persistence;

use App\Contexts\Core\Domain\Persistence\MemberRestoreRecord;
use App\Contexts\Core\Domain\Value;

trait MemberRecordCreatable
{
    private function createMemberRecord(array $row): MemberRestoreRecord
    {
        $id = Value\Member\Id::fromNumber($row['id']);
        $name = Value\Member\Name::fromString($row['profile']['name'] ?? $row['name']);
        $email = Value\Member\Email::fromString($row['email']);
        return new MemberRestoreRecord(
            $id,
            $name,
            $email,
        );
    }
}
