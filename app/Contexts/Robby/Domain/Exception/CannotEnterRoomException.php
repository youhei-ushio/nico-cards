<?php

declare(strict_types=1);

namespace App\Contexts\Robby\Domain\Exception;

use RuntimeException;

/**
 * 部屋に入室できない場合の例外
 */
final class CannotEnterRoomException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('部屋に入室できません。');
    }
}
