<?php

namespace App\Http\Controllers;

use App\Models\CollectionEvent;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;

class ScoreboardController extends Controller
{
    /**
     * Display homepage
     */
    public function home(Request $request)
    {
        $highScores = Score::orderByDesc('total_score')->limit(7)->get();
        $recentScores = CollectionEvent::with('score')->orderByDesc('updated_at')->limit(7)->get();
        return view('overview',[
            'high_scores' => $highScores,
            'recent_scores' => $recentScores,
        ]);
    }

    /**
     * Display all scores
     */
    public function index(Request $request) {
        $allScores = Score::orderByDesc('total_score')->get();

        return view('scoreboard', [
            'all_scores' => $allScores,
        ]);
    }
}
