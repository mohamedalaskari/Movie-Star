<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MatchWatching extends Model
{
    /** @use HasFactory<\Database\Factories\MatchWatchingFactory> */
    use HasFactory;
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
