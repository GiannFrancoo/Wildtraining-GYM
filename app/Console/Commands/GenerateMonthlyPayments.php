<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Payment;
use App\Models\PaymentStatus;
use Illuminate\Console\Command;
use App\Models\UserSubscription;
use App\Models\UserSubscriptionStatus;

class GenerateMonthlyPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:subscriptions-monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generar pagos mensuales para suscripciones activas';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //Comando para generar los pagos automaticos todos los 1ro de los meses (Anda)
        $now = Carbon::today();
        if ($now !== Carbon::today()->firstOfMonth()) {
            return;
        }

        $userSubscriptions = UserSubscription::query()
            ->where('user_subscription_status_id', UserSubscriptionStatus::ACTIVE)
            ->with('user', 'subscription')
            ->get();

        $userSubscriptions->each(function ($userSubscription) {
            $payment = Payment::create([
                "user_subscription_id" => $userSubscription->id,
                "price" => $userSubscription->subscription->month_price,
                "date" => now(),
                "payment_status_id" => PaymentStatus::PENDING, 
                "payment_status_updated_at" => now(),
            ]);
        });
    }
}
