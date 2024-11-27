<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Series extends Model
{
    /** @use HasFactory<\Database\Factories\SeriesFactory> */
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'discription',
        'series_name',
        'num_of_seasons',
        'genre_id',
    ];
    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
    ];
    public function seasons(): HasMany
    {
        return $this->hasMany(Season::class);
    }
    public function genres(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }
}
