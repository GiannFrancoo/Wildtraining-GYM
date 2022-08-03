<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\Subscription\SubscriptionStoreRequest;
use App\Http\Requests\Subscription\SubscriptionUpdateRequest;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Support\Arr;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        try{
        
            $subscriptions = Subscription::all();
            $users = User::whereHas('lastSubscription')->get();
            $subscriptionArray = array();
            $totalSubscription = 0;

            foreach ($subscriptions as $subscription){
                $totalSubscription = 0;            

                foreach ($users as $user){
                    if ($user->lastSubscription->isNotEmpty()){
                        if ($subscription->id == $user->lastSubscription->first()->id){
                            $totalSubscription++;
                        }
                    }
                }

                $subscriptionArray = Arr::add($subscriptionArray, $subscription->id, $totalSubscription);
            }

            return view('subscription.subscription')->with(['subscriptions' => $subscriptions, 'subscriptionArray' => $subscriptionArray]);
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al mostrar los planes');
        }   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('subscription.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriptionStoreRequest $request)
    {
        try {
            $subscription = new Subscription();
            $subscription->name = $request->name;
            $subscription->times_a_week = $request->times_a_week;
            $subscription->month_price = $request->month_price;
            $subscription->modification_date = Carbon::now();
            
            $subscription->save();

            return redirect()->route('subscription.index')->withSuccess('Subscripción agregada correctamente');
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al guardar la nueva subscripción');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($subscription_id)
    {   
        try{
            $subscription = Subscription::findOrFail($subscription_id);

            $users = User::whereHas('lastSubscription', function($query) use ($subscription){
                $query->where('subscriptions.id', $subscription->id);     
            })->get();

            return view('subscription.show')->with(['subscription' => $subscription, 'users' => $users]);

        }
        catch (Exception $e){
            return redirect()->back()->withErrors('Error al mostrar el plan');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $subscription = Subscription::find($id);
            return view('subscription.edit')->with('subscription', $subscription);
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al editar un plan');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubscriptionUpdateRequest $request, $id)
    {
        try{
            $subscription = Subscription::findOrFail($id);
            $subscription->name = $request->name;
            $subscription->times_a_week = $request->times_a_week;
            $subscription->month_price = $request->month_price;
            $subscription->modification_date = now();
            
            $subscription->save();
            return redirect()->route('subscription.index')->withSuccess('Subscripción modificada correctamente');
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al editar una subscripción');
        }    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $subscription = Subscription::findOrFail($id);  
            
            $userSubscriptions = UserSubscription::where('subscription_id', $subscription->id)->get();
            
            $userSubscriptions->each(function ($userSubscription){
                $userSubscription->payments()->delete();
                $userSubscription->delete();
            });

            $subscription->delete();

            return redirect()->route('subscription.index')->withSuccess('Se elimino correctamente');
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al eliminar la subscripción');
        }
    }
}