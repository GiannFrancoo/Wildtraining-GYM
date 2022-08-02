<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subscriptions = [
            ['name' => 'Principiante', 'times_a_week' => '2', 'month_price' => '2700.00', 'modification_date'=>now()],
            ['name' => 'Amateur', 'times_a_week' => '3', 'month_price' => '3000.00', 'modification_date' => now()],
            ['name' => 'Libre', 'times_a_week' => '5', 'month_price' => '3500.00', 'modification_date' => now()]
        ];

        foreach ($subscriptions as $subscription) {
            Subscription::updateOrCreate($subscription);
        } 

    }
}
