<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSubscriptionStatus extends Model
{
    use SoftDeletes;
    
    protected $table = 'user_subscription_statuses';

    const ACTIVE = 1;
    const INACTIVE = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function userSubscriptions()
    {
        return $this->hasMany(UserSubscription::class, 'user_subscription_status_id');
    }
}