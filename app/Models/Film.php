<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Film extends Model
{
    /** @use HasFactory<\Database\Factories\FilmFactory> */
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'description',
        'name',
        'film_url',
        'genre_id'
    ];
    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
    ];
    public function genres(): BelongsTo
    {
        return $this->BelongsTo(Genre::class);
    }
    public function film_watchings(): HasMany
    {
        return $this->HasMany(FilmWatching::class);
    }
}
