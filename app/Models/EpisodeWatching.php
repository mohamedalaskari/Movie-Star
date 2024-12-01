<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EpisodeWatching extends Model
{
    /** @use HasFactory<\Database\Factories\EpisodeWatchingFactory> */
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'user_id',
        'episode_id',
    ];
    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
    ];
    public function users(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
    public function episodes(): BelongsTo
    {
        return $this->BelongsTo(Episode::class);
    }
}
