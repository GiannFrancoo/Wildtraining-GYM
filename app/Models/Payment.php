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

    public function user_subscription(){
        return $this->belongsTo(User_subscription::class);
    }
}
