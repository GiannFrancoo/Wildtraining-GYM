<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subscriptions')->insert([
            'name'              => 'Principiante',   
            'times_a_week'      => '2',
            'month_price'       => '2400.00',
            'modification_date' => now(),         
        ]);

        DB::table('subscriptions')->insert([
            'name'              => 'Pro',   
            'times_a_week'      => '3',
            'month_price'       => '2700.00',
            'modification_date' => now(),         
        ]);

        DB::table('subscriptions')->insert([
            'name'              => 'Libre',   
            'times_a_week'      => '5',
            'month_price'       => '3000.00',
            'modification_date' => now(),         
        ]);
    }
}
