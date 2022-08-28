<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Exception;

use LogicException;

/**
 * プレイヤーが多すぎる場合の例外
 */
final class TooManyPlayersException extends LogicException
{
    public function __construct()
    {
        parent::__construct('プレイヤーが多すぎます。');
    }
}
