<?php

namespace App\Models;

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
        'secundary_phone',
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

        return "{$this->name} {$this->last_name}";
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

    public function assistances()
    {
        return $this->hasMany(Assistance::class);
    }

    public function lastSubscription()
    {
        return $this
            ->belongsToMany(Subscription::class, 'user_subscriptions', 'user_id', 'subscription_id')
            ->using(UserSubscription::class)
            ->withPivot('id', 'start_date')
            ->withTimestamps()
            ->where('user_subscriptions.deleted_at', NULL)
            ->latest();
    }

    public function subscriptions()
    {
        return $this
            ->belongsToMany(Subscription::class, 'user_subscriptions', 'user_id', 'subscription_id')
            ->using(UserSubscription::class)
            ->withPivot('id', 'start_date')
            ->withTimestamps()
            ->where('user_subscriptions.deleted_at', NULL);
    }

    
    public function social_work()
    {
        return $this->belongsTo(SocialWork::class);
    }
}
