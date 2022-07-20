<?php

namespace App\Http\Controllers;

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
        $users = User::orderBy('last_name')->get();
        $monthlyRevenue = 0;
        $usersWithoutSubscription = 0;

        foreach ($users as $user) {
            if($user->subscriptions()->latest()->first() != null){
                $monthlyRevenue = $monthlyRevenue + $user->subscriptions()->latest()->first()->month_price;  
            }  
            else{
                $usersWithoutSubscription++;
            }        
        }

        return view('home',)->with(['users' => $users, 'monthlyRevenue' => $monthlyRevenue, 'usersWithoutSubscription' => $usersWithoutSubscription]);
    }
}
