<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentStatus extends Model
{
    use SoftDeletes;
    
    protected $table = 'payment_statuses';

    const PENDING = 1;
    const PAID = 2;
    const CANCELLED = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'payment_status_id', 'id');
    }




}
