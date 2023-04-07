<?php

namespace App\Console\Commands;

use App\Models\TokenHolder;
use Illuminate\Console\Command;

class create_tokenholder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create_tokenholder {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new tokenholder';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tokenholder = new TokenHolder;
        $tokenholder->name = $this->argument('name');
        $tokenholder->save();

        $this->comment('New TokenHolder created: ' . $this->argument('name'));
    }
}
