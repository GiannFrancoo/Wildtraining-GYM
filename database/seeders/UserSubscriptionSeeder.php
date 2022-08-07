<?php

namespace Database\Seeders;

use App\Models\UserSubscription;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class UserSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userSubscriptions = [
            ['id' => 1, 'user_id' => 1, 'subscription_id' => 1, 'start_date' => Carbon::now()->subYears(rand(1, 55)), 'user_subscription_status_id' => 1, 'user_subscription_status_updated_at' => Carbon::now()],
            ['id' => 2, 'user_id' => 1, 'subscription_id' => 2, 'start_date' => Carbon::now()->subYears(rand(1, 55)), 'user_subscription_status_id' => 2, 'user_subscription_status_updated_at' => Carbon::now()],  
        ];

        foreach ($userSubscriptions as $userSubscription) {
            UserSubscription::updateOrCreate($userSubscription);
        } 

        UserSubscription::factory(20)->create();
    }
}
