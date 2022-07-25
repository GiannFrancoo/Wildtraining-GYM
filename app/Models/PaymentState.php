<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentState extends Model
{
    use SoftDeletes;
    
    protected $table = 'payment_statuses';

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
        return $this->hasMany(Payment::class);
    }




}
