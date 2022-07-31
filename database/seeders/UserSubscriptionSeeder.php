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
            /*['id' => 3, 'user_id' => 2, 'subscription_id' => 2, 'start_date' => Carbon::now()->subYears(rand(1, 55)), 'user_subscription_status_id' => 1, 'user_subscription_status_updated_at' => Carbon::now()],
            ['id' => 4, 'user_id' => 3, 'subscription_id' => 2, 'start_date' => Carbon::now()->subYears(rand(1, 55)), 'user_subscription_status_id' => 1, 'user_subscription_status_updated_at' => Carbon::now()],
            ['id' => 5, 'user_id' => 4, 'subscription_id' => 1, 'start_date' => Carbon::now()->subYears(rand(1, 55)), 'user_subscription_status_id' => 1, 'user_subscription_status_updated_at' => Carbon::now()],
            ['id' => 6, 'user_id' => 5, 'subscription_id' => 3, 'start_date' => Carbon::now()->subYears(rand(1, 55)), 'user_subscription_status_id' => 1, 'user_subscription_status_updated_at' => Carbon::now()],
            ['id' => 7, 'user_id' => 6, 'subscription_id' => 1, 'start_date' => Carbon::now()->subYears(rand(1, 55)), 'user_subscription_status_id' => 1, 'user_subscription_status_updated_at' => Carbon::now()],
            ['id' => 8, 'user_id' => 7, 'subscription_id' => 2, 'start_date' => Carbon::now()->subYears(rand(1, 55)), 'user_subscription_status_id' => 1, 'user_subscription_status_updated_at' => Carbon::now()],
            ['id' => 9, 'user_id' => 8, 'subscription_id' => 3, 'start_date' => Carbon::now()->subYears(rand(1, 55)), 'user_subscription_status_id' => 1, 'user_subscription_status_updated_at' => Carbon::now()],
            ['id' => 10, 'user_id' => 9, 'subscription_id' => 2, 'start_date' => Carbon::now()->subYears(rand(1, 55)), 'user_subscription_status_id' => 1, 'user_subscription_status_updated_at' =>Carbon::now()],
            ['id' => 11, 'user_id' => 10, 'subscription_id' => 1, 'start_date' => Carbon::now()->subYears(rand(1, 55)), 'user_subscription_status_id' => 1, 'user_subscription_status_updated_at' => Carbon::now()],
            ['id' => 12, 'user_id' => 11, 'subscription_id' => 2, 'start_date' => Carbon::now()->subYears(rand(1, 55)), 'user_subscription_status_id' => 1, 'user_subscription_status_updated_at' => Carbon::now()],
            ['id' => 13, 'user_id' => 12, 'subscription_id' => 3, 'start_date' => Carbon::now()->subYears(rand(1, 55)), 'user_subscription_status_id' => 1, 'user_subscription_status_updated_at' => Carbon::now()],*/
            
        ];

        foreach ($userSubscriptions as $userSubscription) {
            UserSubscription::updateOrCreate($userSubscription);
        } 

    }
}
