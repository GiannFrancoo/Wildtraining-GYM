<?php

namespace Database\Seeders;

use App\Models\UserSubscriptionStatus;
use Illuminate\Database\Seeder;

class UserSubscriptionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userSubscriptionStatuses = [
            ['id' => 1, 'name' => 'Activa', 'color' => 'success'],
            ['id' => 2, 'name' => 'Inactiva', 'color' => 'dark'],
        ];

        foreach ($userSubscriptionStatuses as $userSubscriptionStatus) {
            UserSubscriptionStatus::updateOrCreate($userSubscriptionStatus);
        } 

    }
}
