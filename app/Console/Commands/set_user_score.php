<?php

namespace App\Console\Commands;

use App\Models\Score;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class set_user_score extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set_user_score {uuid} {newValue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $validator = Validator::make([
                'uuid' => $this->argument('uuid'),
                'newScore' => $this->argument('newValue')
            ],[
                'uuid' => 'uuid',
                'newScore' => 'integer'
            ]);

            if ($validator->fails()) {
                $this->info('Failed to update user score');

                foreach ($validator->errors()->all() as $error) {
                    $this->error($error);
                }
                return 1;
            }

        if ($score = Score::firstWhere('user_uuid', $this->argument('uuid'))) {
            $oldScore = $score->current_score;
            $score->current_score = $this->argument('newValue');
            $score->save();
            $this->comment("{$score->user_uuid} | Old Score: {$oldScore} | Current Score: {$score->current_score} | Total Score: {$score->total_score}");
            return;
        }

        $this->comment('The provided UUID could not be found in the database');
    }
}
