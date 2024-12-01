<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class FilmWatching extends Model
{
    /** @use HasFactory<\Database\Factories\FilmWatchingFactory> */
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'user_id',
        'film_id',
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
    public function films(): BelongsTo
    {
        return $this->BelongsTo(Film::class);
    }
}
