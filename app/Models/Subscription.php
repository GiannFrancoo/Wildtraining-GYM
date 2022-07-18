<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use SoftDeletes;

    protected $table = "subscriptions";
    protected $fillable = [
        'name',
        'times_a_week',
        'month_price',
        'modification_date'
    ];

    protected $casts = [
        "modification_date" => "date",
    ];

    public function users()
    {
        return $this
            ->belongsToMany(User::class, 'user_subscriptions', 'subscription_id', 'user_id')
            ->using(UserSubscription::class)
            ->withPivot('start_date')
            ->withTimestamps()
            ->where('user_subscriptions.deleted_at', NULL);
    }
}
