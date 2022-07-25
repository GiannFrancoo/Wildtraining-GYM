<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $table = "payments";
    protected $fillable = [
        'user_subscription_id',
        'price',
        'date',
    ];

    protected $casts = [
        "date" => "datetime",
    ];

    public function userSubscription(){
        return $this->belongsTo(UserSubscription::class);
    }

    public function paymentStatuses()
    {
        return $this->belongsTo(PaymentState::class);
    }
}
