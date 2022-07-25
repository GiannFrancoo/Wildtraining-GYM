<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use App\Models\Subscription;
use App\Models\UserSubscription;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::all();
        return view('payment.index')->with('payments', $payments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $subscriptions = Subscription::all();
        return view('payment.create')->with('subscriptions', $subscriptions)->with('users', $users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $payment_id)
    {
        $user = User::with('lastSubscription')->findOrfail($payment_id);
        $userSubscription = $user->lastSubscription->first()->pivot;

        $userSubscription->payments()->create([
            "user_subscription_id" => $userSubscription->id,
            "price" => $request->price,
            "date" => $request->date,
        ]);

        return redirect()
            ->route('payment.index')
            ->withSuccess('Se creo el nuevo pago con exito');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($payment_id)
    {
        //
    }

    public function users()
    {
        $users = User::all();
        $selectedUser = null;
        $subscription = null;

        if (isset($_GET['user'])) {
            $selectedUser = User::with('lastSubscription')->find($_GET['user']);
            $subscription = $selectedUser->lastSubscription->first();

            if (is_null($subscription)) {
                return redirect()
                    ->back()
                    ->with('error', 'El usuario no tiene suscripción');
            }
        }

        return view('payment.users')->with([
            'users' => $users,
            'selectedUser' => $selectedUser,
            'subscription' => $subscription,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($payment_id)
    {
        $payment = Payment::findOrFail($payment_id);
        $users = User::all();
        $subscriptions = Subscription::all();
        return view('payment.edit')->with('payment', $payment)->with('users', $users)->with('subscriptions', $subscriptions);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $payment_id)
    {
        //
        $payments = Payment::all();
       $payment = Payment::findOrFail($payment_id);
        $payment->price = $request->price;
        $payment->date = $request->date;
       // $payment->user_subscription_id = UserSubscription::where('user_id', $request->userSelected)->where('subscription_id', $request->subscriptionSelected)->latest()->first()->id;
        $payment->save();

        return redirect()->route('payment.index')->with('payments', $payments)->withSuccess('Los cambios se guardaron con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($payment_id)
    {
        //try{
            
        $payments = Payment::all();
            $payment = Payment::findOrFail($payment_id);
             $payment->delete();

             return redirect()->route('payment.index')->with('payments', $payments)->withSuccess('Se elimino con exito el pago');
             //}catch(Exception e){}
       
    }

    public function userSelected($payment_id){
        $user = User::findOrFail($payment_id);
        $subscription = UserSubscription::where('user_id', $user->id)->latest()->first()->subscription()->first();
        $timePayment = now();
        $priceSubscription = UserSubscription::where('user_id', $user->id)->latest()->first()->subscription()->first()->month_price;
        $fecha_hora = now();     

        return view('payment.userSelected')->with('user', $user)->with('timePayment', $timePayment)->with('priceSubscription', $priceSubscription)->with('subscription', $subscription)->with('dayHour', $fecha_hora);
    }
}
