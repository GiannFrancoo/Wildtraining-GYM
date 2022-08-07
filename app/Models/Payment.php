<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = "payments";
    protected $fillable = [
        'user_subscription_id',
        'price',
        'date',
        'payment_status_id',
        'payment_status_updated_at',

    ];

    protected $casts = [
        'date' => 'datetime',
        'payment_status_updated_at' => 'date', 
        
    ];

    public function userSubscription(){
        return $this->belongsTo(UserSubscription::class);
    }

    public function paymentStatus()
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id', 'id');
    }
}
