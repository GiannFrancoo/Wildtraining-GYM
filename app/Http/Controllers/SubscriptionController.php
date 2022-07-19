<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\Subscription\SubscriptionStoreRequest;
use App\Http\Requests\Subscription\SubscriptionUpdateRequest;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptions = Subscription::orderBy('times_a_week')->get();
        return view('subscription.subscription')->with('subscriptions', $subscriptions);
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
    public function store(Request $request)
    {
        try{
            $subscription = new Subscription();
            $subscription->name = $request->name;
            $subscription->times_a_week = $request->times_a_week;
            $subscription->month_price = $request->month_price;
            $subscription->modification_date = Carbon::now();
            
            $subscription->save();

            return redirect()->route('subscription.index')->withSuccess('Subscripción agregada correctamente');
        }
        catch(Exception $e){
            return redirect()->back->withErrors('Error al guardar la nueva subscripción');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //not neccesary
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
            return redirect()->back()->withErrors('Error al editar una susbscripción');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
            $subcription = Subscription::findOrFail($id);            
            $subcription->delete();

            return redirect()->route('subscription.index')->withSuccess('Se elimino correctamente');
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al eliminar la subscripción');
        }
    }
}
