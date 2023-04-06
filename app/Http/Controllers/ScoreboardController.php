<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;

class ScoreboardController extends Controller
{
    /**
     * Display an overview with all the scores
     */
    public function index(Request $request)
    {
        return view('overview');
    }
}
