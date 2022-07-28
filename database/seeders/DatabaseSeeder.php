<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            GenderSeeder::class,
            PaymentStatusSeeder::class,
            UserSubscriptionStatusSeeder::class,
            SocialWorkSeeder::class,
            UserSeeder::class,
            SubscriptionSeeder::class,
            UserSubscriptionSeeder::class,
            PaymentSeeder::class,
        ]);
        
        

    }
}
