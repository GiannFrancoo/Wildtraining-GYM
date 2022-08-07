<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserSubscription extends Pivot
{
    use SoftDeletes, HasFactory;

    protected $table = "user_subscriptions";
    protected $fillable = [
        'id',
        'user_id',
        'subscription_id',
        'start_date',
        'payment_id',
        'user_subscription_status_id',
        'user_subscription_status_updated_at',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'user_subscription_status_updated_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_subscription_id');
    }

    public function status()
    {
        return $this->belongsTo(UserSubscriptionStatus::class, 'user_subscription_status_id', 'id');
    }
    
}
