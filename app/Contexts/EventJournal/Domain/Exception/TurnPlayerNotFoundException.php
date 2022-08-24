<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Exception;

use LogicException;

/**
 * ターン中のプレイヤーがいない場合の例外
 */
final class TurnPlayerNotFoundException extends LogicException
{
    public function __construct()
    {
        parent::__construct('ターン中のプレイヤーが見つかりません。');
    }
}
