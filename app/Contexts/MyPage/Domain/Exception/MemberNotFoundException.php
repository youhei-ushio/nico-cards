<?php

declare(strict_types=1);

namespace App\Contexts\MyPage\Domain\Exception;

use BadMethodCallException;

/**
 * ID等で検索したエンティティが見つからない場合の例外
 */
final class MemberNotFoundException extends BadMethodCallException
{
    public function __construct()
    {
        parent::__construct('データが見つかりません。');
    }
}
