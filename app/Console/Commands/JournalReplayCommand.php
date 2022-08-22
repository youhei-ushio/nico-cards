<?php

namespace App\Console\Commands;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\UseCase\Replay\Input;
use App\Contexts\EventJournal\UseCase\Replay\Interactor;
use Illuminate\Console\Command;

final class JournalReplayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'journal:replay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replay event journals.';

    /**
     * Execute the console command.
     *
     * @param Interactor $interactor
     * @return int
     */
    public function handle(Interactor $interactor): int
    {
        $input = new Input(Value\Room\Id::fromNumber(1)); // TODO
        $interactor->execute($input);
        return 0;
    }
}
