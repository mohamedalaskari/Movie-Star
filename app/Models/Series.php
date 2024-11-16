<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Series extends Model
{
    /** @use HasFactory<\Database\Factories\SeriesFactory> */
    use HasFactory;
    public function seasons() : HasMany
    {
        return $this->hasMany(Season::class);
    }
    public function genre() : BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }
}
