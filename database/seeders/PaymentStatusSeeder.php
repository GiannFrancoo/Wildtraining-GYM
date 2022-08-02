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
            ['id' => 1, 'name' => 'Pendiente', 'color' => 'warning'],
            ['id' => 2, 'name' => 'Pagado', 'color' => 'success'],
            ['id' => 3, 'name' => 'Cancelado', 'color' => 'secondary'],
        ];

        foreach ($paymentStatuses as $paymentStatus) {
            PaymentStatus::updateOrCreate($paymentStatus);
        } 

    }
}
