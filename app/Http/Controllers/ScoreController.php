<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;
use Nette\NotImplementedException;

class ScoreController extends Controller
{

    /**
     * Returns the user's current score record
     */
    public function show(string $uuid)
    {
        // $score = Score::find(1);
        $score = Score::where('user_uuid', '=', '1')->firstOrFail();

        return [
            'status' => 1,
            'uuid' => $score->user_uuid,
            'current_score' => $score->current_score,
            'total_score' => $score->total_score
        ];
    }

    /**
     * Increments the user's score by 1
     */
    public function increment(Request $request, string $uuid) {
        $validated = $request->validate([
            'uuid' => 'required|uuid',
            'username' => 'required|string',
            'legacy_username' => 'required|string',
        ]
        );

        $score = Score::firstOrCreate([
            'user_uuid' => $validated['uuid']
        ]);

        $score->username = $validated['username'];
        $score->legacy_username = $validated['legacy_username'];

        $score->current_score++;
        $score->total_score++;

        $score->save();

        return [
            'status' => 1,
            'uuid' => $score->user_uuid,
            'current_score' => $score->current_score,
            'total_score' => $score->total_score,
        ];
    }
}
