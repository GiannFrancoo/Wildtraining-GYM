<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payments = [
            ['id' => 1, 'user_subscription_id' => 1, 'price' => 2700, 'date' => Carbon::now()->subYears(rand(1, 55)), 'payment_status_id' => rand(1, 3), 'payment_status_updated_at' => Carbon::now()],
            ['id' => 2, 'user_subscription_id' => 2, 'price' => 2500, 'date' => Carbon::now()->subYears(rand(1, 55)), 'payment_status_id' => rand(1, 3), 'payment_status_updated_at' => Carbon::now()],
            //['id' => 3, 'user_subscription_id' => 3, 'price' => 3000, 'date' => Carbon::now()->subYears(rand(1, 55)), 'payment_status_id' => rand(1, 3), 'payment_status_updated_at' => Carbon::now()],
        ];

        foreach ($payments as $payment) {
            Payment::updateOrCreate($payment);
        } 

    }
}
