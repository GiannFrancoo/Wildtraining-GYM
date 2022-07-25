<?php

namespace Database\Seeders;

use App\Models\PaymentStatus;
use Illuminate\Database\Seeder;

class PaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paymentStatuses = [
            ['id' => 1, 'name' => 'Pendiente'],
            ['id' => 2, 'name' => 'Pagado'],
            ['id' => 3, 'name' => 'Cancelado'],
        ];

        foreach ($paymentStatuses as $paymentStatus) {
            PaymentStatus::updateOrCreate($paymentStatus);
        } 

    }
}
