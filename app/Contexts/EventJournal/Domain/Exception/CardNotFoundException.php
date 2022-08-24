<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Exception;

use InvalidArgumentException;

/**
 * 手札に該当カードを持っていない場合の例外
 */
final class CardNotFoundException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('指定のカードを持っていません。');
    }
}
