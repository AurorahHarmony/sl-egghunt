<?php

namespace App\Console\Commands;

use App\Models\TokenHolder;
use Carbon\Carbon;
use Illuminate\Console\Command;

class create_token extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create_token {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new token for the specified tokenholder';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        try {
           $tokenHolder =  TokenHolder::where('name', '=', $name)->firstOrFail();
        } catch (\Throwable $th) {
            return $this->comment('User could not be found');
        }

        $timestamp = Carbon::now('PST');
        $newToken = $tokenHolder->createToken($timestamp);

        $this->comment('New token created for ' . $name . ': ' . $newToken->plainTextToken);
    }
}
