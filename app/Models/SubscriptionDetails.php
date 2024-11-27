<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionDetails extends Model
{
    /** @use HasFactory<\Database\Factories\SubscriptionDetailsFactory> */
    use HasFactory,SoftDeletes;
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function subscriptions(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }
}
