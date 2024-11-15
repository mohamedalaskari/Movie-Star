<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Film extends Model
{
    /** @use HasFactory<\Database\Factories\FilmFactory> */
    use HasFactory;
    public function users () : HasMany
    {
        return $this->hasMany(User::class);
    }
    
    public function genre() : BelongsTo
    {
         $this->BelongsTo(Genre::class);
    }
}
