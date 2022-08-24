<?php

declare(strict_types=1);

namespace App\Contexts\Core\Infrastructure\Persistence;

use App\Contexts\Core\Domain\Persistence\MemberRestoreRecord;

trait MemberRecordCreatable
{
    private function createMemberRecord(array $row): MemberRestoreRecord
    {
        return new MemberRestoreRecord(
            id: $row['id'],
            name: $row['profile']['name'] ?? $row['name'],
            email: $row['email'],
        );
    }
}
