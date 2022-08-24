<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Exception;

use LogicException;

/**
 * ID等で検索したエンティティが見つからない場合の例外
 */
final class FirstTurnPlayerNotFoundException extends LogicException
{
    public function __construct()
    {
        parent::__construct('最初のターンのプレイヤーが見つかりません。');
    }
}
