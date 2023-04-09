<?php

namespace App\Http\Controllers;

use App\Models\CollectionEvent;
use App\Models\Purchase;
use App\Models\Score;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{

    /**
     * Returns the user's current score record
     */
    public function show(string $uuid)
    {
        // $score = Score::find(1);
        $score = Score::where('user_uuid', '=', $uuid)->firstOrFail();

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
        $request->merge(['uuid' => $uuid]);
        $validated = $request->validate([
            'uuid' => 'required|uuid',
            'username' => 'required|string',
            'legacy_username' => 'required|string',
        ],
        );

        $score = Score::firstOrCreate([
            'user_uuid' => $validated['uuid']
        ]);

        $egg_id = $request->header('X-SecondLife-Object-Key');

        $minuteDelay = 60; // How many minutes until an egg can be recollected.

        // Check if this egg has already been collected in the last hour. Fail if it has.
        if ($lastCollection = CollectionEvent::firstWhere([
            ['updated_score', $score->id],
            ['egg_id', $egg_id],
            ['created_at', '>', Carbon::now()->subMinutes($minuteDelay)->toDateTimeString()]]))
            {
            $remaining = Carbon::createFromTimeString($lastCollection->updated_at)->addMinutes($minuteDelay);
            return [
                'status' => 2,
                'message' => 'You can next collect this egg in ' . $remaining->diffForHumans(Carbon::now(),true, true, 2)
            ];
        }

        // Update user details and score
        $score->username = $validated['username'];
        $score->legacy_username = $validated['legacy_username'];

        $score->current_score++;
        $score->total_score++;

        // Get info about egg to store in event log.
        $collectionEvent = new CollectionEvent();
        $collectionEvent->egg_id = $egg_id;
        $collectionEvent->region = $request->header('X-SecondLife-Region');
        $collectionEvent->position = $request->header('X-SecondLife-Local-Position');
        $collectionEvent->score()->associate($score);

        DB::transaction(function() use (&$score, &$collectionEvent) {
            $score->save();
            $collectionEvent->save();
        });

        return [
            'status' => 1,
            'uuid' => $score->user_uuid,
            'current_score' => $score->current_score,
            'total_score' => $score->total_score,
        ];
    }

    public function purchase(Request $request, string $uuid) {
        $request->merge(['uuid' => $uuid]);
        $validated = $request->validate(
            [
                'uuid' => 'required|uuid', // User's uuid
                'item_name' => 'required|string',
                'price' => 'required|integer|min:0',
            ],
        );

        $validated['item_name'] = mb_strtolower(trim($validated['item_name']), 'UTF-8');

        $score = Score::firstOrCreate([
            'user_uuid' => $validated['uuid']
        ]);

        // Return Success if already purchased
        if ($purchased = Purchase::firstWhere([
            ['updated_score', $score->id],
            ['item_name', $validated['item_name']]
        ])) {
            return [
                'status' => 1,
                'uuid' => $score->user_uuid,
                'message' => 'You have already purchased this item.',
                'current_score' => $score->current_score,
                'total_score' => $score->total_score,
            ];
        }

        // Check if user can afford it
        if ($score->current_score < $validated['price']) {
            return [
                'status' => 0,
                'uuid' => $score->user_uuid,
                'message' => 'You cannot afford this item.',
                'current_score' => $score->current_score,
                'total_score' => $score->total_score,
            ];
        }

        // Subtract from current store and create purchase record.
        $score->current_score = $score->current_score - $validated['price'];

        // Add purchase event
        $purchase = new Purchase();
        $purchase->item_name = $validated['item_name'];
        $purchase->price = $validated['price'];
        $purchase->score()->associate($score);

        DB::transaction(function() use (&$score, &$purchase) {
            $score->save();
            $purchase->save();
        });

        return [
            'status' => 1,
            'uuid' => $score->user_uuid,
            'current_score' => $score->current_score,
            'total_score' => $score->total_score,
        ];
    }
}
