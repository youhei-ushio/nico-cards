<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Exception;

use LogicException;

/**
 * 不明なイベントの例外
 */
final class UnknownEventException extends LogicException
{
    public function __construct()
    {
        parent::__construct('イベントを処理できません。');
    }
}
