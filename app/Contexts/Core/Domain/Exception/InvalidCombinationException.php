<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Exception;

use InvalidArgumentException;

/**
 * 不正な組み合わせのカード検出時の例外
 */
final class InvalidCombinationException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('不正な組み合わせのカードです。');
    }
}
