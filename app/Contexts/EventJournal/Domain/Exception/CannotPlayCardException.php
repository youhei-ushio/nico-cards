<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Exception;

use RuntimeException;

/**
 * カードが出せない場合の例外
 */
final class CannotPlayCardException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('カードが出せません。');
    }
}
