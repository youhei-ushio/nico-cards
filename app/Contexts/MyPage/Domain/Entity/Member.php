<?php

declare(strict_types=1);

namespace App\Contexts\MyPage\Domain\Entity;

use App\Contexts\MyPage\Domain\Persistence\MemberRepository;
use App\Contexts\MyPage\Domain\Persistence\MemberSaveRecord;
use App\Core\Domain\Persistence\MemberRestoreRecord;
use App\Core\Domain\Value;

/**
 * メンバー
 */
final class Member
{
    /**
     * newによるインスタンス化はさせない
     *
     * @param Value\Member\Id $id
     * @param Value\Member\Name $name
     * @see restore()
     */
    private function __construct(
        private readonly Value\Member\Id $id,
        private Value\Member\Name $name,
    )
    {

    }

    /**
     * @param Value\Member\Name $name
     */
    public function rename(Value\Member\Name $name): void
    {
        $this->name = $name;
    }

    /**
     * 永続化されたエンティティを復元する
     *
     * @param MemberRestoreRecord $record
     * @return self
     */
    public static function restore(MemberRestoreRecord $record): self
    {
        return new self(
            id: $record->id,
            name: $record->name,
        );
    }

    /**
     * エンティティを永続化する
     *
     * @param MemberRepository $repository
     * @return void
     */
    public function save(MemberRepository $repository): void
    {
        $repository->save(new MemberSaveRecord($this->id, $this->name));
    }
}
