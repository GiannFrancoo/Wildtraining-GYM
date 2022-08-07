<?php

namespace Database\Factories;

use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Type\Integer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [      
            'user_subscription_id'      => UserSubscription::inRandomOrder()->first()->id,
            'price'                     => rand(2500, 5000),
            'date'                      => Carbon::now()->subYears(rand(1, 55))->subMonth(rand(1, 12))->subDay(rand(1, 20)),
            'payment_status_id'         => rand(1, 3),
            'payment_status_updated_at' => Carbon::now(),
        ];
    }
}
