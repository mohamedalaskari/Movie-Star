<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matches extends Model
{
    /** @use HasFactory<\Database\Factories\MatchesFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'match_url',
        'stadium',
        'team_1',
        'team_1_logo',
        'team_2_logo',
        'team_2',
        'champion',
        'result',
    ];
    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
    ];
    public function match_watchings(): HasMany
    {
        return $this->hasMany(MatchWatching::class);
    }
}
