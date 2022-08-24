<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Exception;

use LogicException;

/**
 * 自分のターンではない場合の例外
 */
final class CannotPlayTurnException extends LogicException
{
    public function __construct()
    {
        parent::__construct('このターンにはプレイできません。');
    }
}
