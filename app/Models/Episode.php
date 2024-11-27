<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Episode extends Model
{
    /** @use HasFactory<\Database\Factories\EpisodeFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'episode_number',
        'description',
        'episode_url',
        'season_id',
    ];
    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
    ];

    public function seasons(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }
    public function episode_watchings(): HasMany
    {
        return $this->HasMany(EpisodeWatching::class);
    }
}
