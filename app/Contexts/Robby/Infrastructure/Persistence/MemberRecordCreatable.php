<?php

declare(strict_types=1);

namespace App\Contexts\Robby\Infrastructure\Persistence;

use App\Core\Domain\Persistence\MemberRestoreRecord;
use App\Core\Domain\Value;

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