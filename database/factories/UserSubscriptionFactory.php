<?php

namespace Database\Factories;

use App\Models\Subscription;
use App\Models\User;
use App\Models\UserSubscriptionStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserSubscription>
 */
class UserSubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'                               => User::inRandomOrder()->first()->id,
            'subscription_id'                       => Subscription::inRandomOrder()->first()->id,
            'start_date'                            => Carbon::now()->subYears(rand(1, 55)),
            'user_subscription_status_id'           => UserSubscriptionStatus::inRandomOrder()->first()->id,
            'user_subscription_status_updated_at'   => Carbon::now(),
        ];
    }
}
