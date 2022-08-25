<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Exception;

use RuntimeException;

/**
 * パスできない場合の例外
 */
final class CannotPassException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('パスできません。');
    }
}
