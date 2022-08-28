<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Exception;

use RuntimeException;

/**
 * 対戦を破棄できない場合の例外
 */
final class CannotDestroyRoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('対戦中のラウンドは削除できません。');
    }
}
