<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    /** @use HasFactory<\Database\Factories\CountryFactory> */
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'country',
    ];
    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
    ];

    public function users() : HasMany
    {
        return $this->hasMany(User::class);
    }
}
