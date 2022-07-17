<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_subscription extends Model
{
    use HasFactory, SoftDeletes;

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

    public function payment()
    {
        return $this->hasOne(Payment::class, 'user_subcription_id');
    }




}
