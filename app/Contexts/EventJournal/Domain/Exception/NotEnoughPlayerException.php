<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Exception;

use LogicException;

/**
 * プレイヤーが足りない場合の例外
 */
final class NotEnoughPlayerException extends LogicException
{
    public function __construct()
    {
        parent::__construct('プレイヤーが足りません。');
    }
}
