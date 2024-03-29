<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'primary_phone',
        'secondary_phone',
        'address', 
        'birthday', 
        'start_date', 
        'personal_information', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthday' => 'date',
        'start_date' => 'date',
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        if (is_null($this->last_name)) {
            return "{$this->name}";
        }

        return "{$this->last_name} {$this->name}";
    }
    
    /**
     * Get the age of the user
     */
    public function getAge(){
        return Carbon::parse($this->attributes['birthday'])->age;
    }

    /**
     * Set the user's password.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function assistances()
    {
        return $this->hasMany(Assistance::class);
    }

    public function lastAssistances()
    {
        return $this
            ->hasMany(Assistance::class)
            ->orderBy('date','desc');
    }

    public function lastSubscription()
    {
        return $this
            ->belongsToMany(Subscription::class, 'user_subscriptions', 'user_id', 'subscription_id')
            ->using(UserSubscription::class)
            ->withPivot('id', 'start_date', 'user_subscription_status_id', 'user_subscription_status_updated_at')
            ->withTimestamps()
            ->where([
                ['user_subscriptions.deleted_at', '=', NULL],
                ['user_subscriptions.user_subscription_status_id', '=', UserSubscriptionStatus::ACTIVE]
            ]);
    }

    public function subscriptions()
    {
        return $this
            ->belongsToMany(Subscription::class, 'user_subscriptions', 'user_id', 'subscription_id')
            ->using(UserSubscription::class)
            ->withPivot('id', 'start_date', 'user_subscription_status_id', 'user_subscription_status_updated_at')
            ->withTimestamps()
            ->where('user_subscriptions.deleted_at', NULL);
    }   
   
}
