<?php

declare(strict_types=1);

namespace App\Contexts\Game\Domain\Exception;

use BadMethodCallException;

/**
 * ID等で検索したエンティティが見つからない場合の例外
 */
final class RoundNotFoundException extends BadMethodCallException
{
    public function __construct()
    {
        parent::__construct('対戦が見つかりません。');
    }
}
