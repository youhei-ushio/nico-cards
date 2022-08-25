<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Exception;

use LogicException;

/**
 * ゲーム中で退室できない場合の例外
 */
final class CannotLeaveException extends LogicException
{
    public function __construct()
    {
        parent::__construct('退室できません。');
    }
}
