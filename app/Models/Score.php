<?php

namespace App\Models;

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
}
