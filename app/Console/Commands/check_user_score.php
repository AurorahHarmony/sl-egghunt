<?php

namespace App\Console\Commands;

use App\Models\Score;
use Illuminate\Console\Command;

class check_user_score extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check_user_score {uuid}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the score of a user by their uuid';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($score = Score::firstWhere('user_uuid', $this->argument('uuid'))) {
            return  $this->comment("{$score->user_uuid} | Current Score: {$score->current_score} | Total Score: {$score->total_score}");
        }

        $this->comment('The provided UUID could not be found in the database');
    }
}
