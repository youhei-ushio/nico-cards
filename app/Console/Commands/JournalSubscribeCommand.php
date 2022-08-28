<?php

namespace App\Console\Commands;

use App\Contexts\EventJournal\UseCase\Replay\Input;
use App\Contexts\EventJournal\UseCase\Replay\Interactor;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class JournalSubscribeCommand extends Command
{
    /**
     * consoleコマンドの名前と使用方法
     *
     * @var string
     */
    protected $signature = 'journal:subscribe';

    /**
     * コンソールコマンドの説明
     *
     * @var string
     */
    protected $description = 'Subscribe to a Redis channel';

    /**
     * consoleコマンドの実行
     *
     * @param Interactor $interactor
     * @return void
     */
    public function handle(Interactor $interactor): void
    {
        Redis::subscribe(['room1'], function ($message) use ($interactor) {
            $input = new Input(
                1, // TODO いったんroom1固定
                1,
            );
            $interactor->execute($input);
        });
    }
}
