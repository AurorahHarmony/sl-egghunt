<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_uuid',
        'current_score',
        'total_score',
    ];

    public function collectionEvents() :HasMany
    {
        return $this->hasMany(CollectionEvent::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    private static function getEndDate() : Carbon {
        return Carbon::createFromFormat('d-m-Y H:i:s',  '17-04-2023 12:00:00', 'PST');
    }

    /**
     * Check if the event is over
     */
    public static function eventOver() : bool
    {
        return self::getEndDate()->isPast();
    }

    /**
     * Check how much time there is remaining
     */
    public static function remainingTime()
    {
        return self::getEndDate()->diffForHumans(Carbon::now(), true, true, 3);
    }
}
