<?php

namespace App\Console\Commands\Bookshelves;

use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\CommandSteward;
use Kiwilan\Steward\Services\DirectoryClearService;

class ClearCommand extends CommandSteward
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear Bookshelves data.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->title();

        DirectoryClearService::make([
            public_path('storage/cache'),
            public_path('storage/cms'),
            public_path('storage/debug'),
            public_path('storage/media'),
            public_path('storage/posts'),
            public_path('storage/settings'),
        ]);

        return Command::SUCCESS;
    }
}
