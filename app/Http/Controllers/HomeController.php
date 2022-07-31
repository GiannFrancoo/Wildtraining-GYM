<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentStatus;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {        
        $pendingPayments = Payment::whereHas('PaymentStatus', function ($query) {
            $query->where('id', PaymentStatus::PENDING);
        })->orderBy('date','desc')->get();
        
        $payments = Payment::take(5)->get();
        
        $users = User::with('lastSubscription')->get();
        $monthlyRevenue = 0;
        $usersWithoutSubscription = 0;

        foreach ($users as $user) {            
            if($user->lastSubscription->isNotEmpty()){
                $monthlyRevenue = $monthlyRevenue + $user->lastSubscription->first()->month_price;  
            }  
            else{
                $usersWithoutSubscription++;
            }        
        }

        return view('home')->with([
            'users' => $users,
            'payments' => $payments,
            'monthlyRevenue' => $monthlyRevenue, 
            'usersWithoutSubscription' => $usersWithoutSubscription,
            'pendingPayments' => $pendingPayments,
            'statusesPayments' => PaymentStatus::all(),
        ]);
    }
}
