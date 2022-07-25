<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionState extends Model
{
    use SoftDeletes;
    
    protected $table = 'user_subscription_statuses';

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
        return $this->hasMany(UserSubscription::class);
    }




}
