<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSubscription extends Pivot
{
    use SoftDeletes;

    protected $table = "user_subscriptions";
    protected $fillable = [
        'user_id',
        'subscription_id',
        'start_date',
        'payment_id',
    ];

    //preguntar ema;
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
}
