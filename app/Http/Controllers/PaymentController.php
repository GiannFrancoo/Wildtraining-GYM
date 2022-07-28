<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\PaymentStatus;
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
        try{
            $payments = Payment::all();
            return view('payment.index')->with('payments', $payments);
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al mostrar los pagos');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            $paymentStatuses = PaymentStatus::all();
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

            return view('payment.create')->with([
                'users' => $users,
                'paymentStatuses' => $paymentStatuses,
                'selectedUser' => $selectedUser,
                'subscription' => $subscription,
            ]);
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al crear el pago');
        } 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $payment_id)
    {
        try{
            $user = User::with('lastSubscription')->findOrfail($payment_id);
            $userSubscription = $user->lastSubscription->first()->pivot;

            $userSubscription->payments()->create([
                'user_subscription_id' => $userSubscription->id,
                'price' => $request->price,
                'date' => $request->date,
                'payment_status_id' => $request->paymentStatus,
                'payment_status_updated_at' => now(),
            ]);

            return redirect()
                ->route('payment.index')
                ->withSuccess('Se creo el nuevo pago con exito');
        }
        catch (Exception $e){
            return redirect()
                ->back()
                ->withErrors('Error al guardar el nuevo pago');
        }
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($payment_id)
    {
        try{
            $paymentsStatuses = PaymentStatus::all();
            $payment = Payment::findOrFail($payment_id);
            $users = User::all();
            $subscriptions = Subscription::all();

            return view('payment.edit')
                ->with([
                    'payment' => $payment,
                    'users' => $users,
                    'subscriptions' => $subscriptions,
                    'paymentsStatuses' => $paymentsStatuses,
                ]);
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al editar una pago');
        }
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
        try{
            $payment = Payment::findOrFail($payment_id);
            $payment->price = $request->price;
            $payment->date = $request->date;
            $payment->payment_status_id = $request->paymentStatus;
            $payment->payment_status_updated_at = now();
            $payment->save();

            return redirect()
                ->route('payment.index')
                ->withSuccess('Los cambios se guardaron con exito');
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al guardar los cambios del pago nuevo');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($payment_id)
    {
        try{      
            $payments = Payment::all();
            $payment = Payment::findOrFail($payment_id);
            $payment->delete();

            return redirect()->route('payment.index')->with('payments', $payments)->withSuccess('Se elimino con exito el pago');
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al eliminar el pago');
        }
    }

    public function userSelected($payment_id)
    {
        try{
            $user = User::findOrFail($payment_id);
            $subscription = UserSubscription::where('user_id', $user->id)->latest()->first()->subscription()->first();
            $timePayment = now();
            $priceSubscription = UserSubscription::where('user_id', $user->id)->latest()->first()->subscription()->first()->month_price;
            $fecha_hora = now();     
    
            return view('payment.userSelected')->with('user', $user)->with('timePayment', $timePayment)->with('priceSubscription', $priceSubscription)->with('subscription', $subscription)->with('dayHour', $fecha_hora);
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al seleccionar el pago');
        }
    }


    /**
     * List of pendant payments
     */
    public function pendant()
    {
        try{
            $pendantPayments = Payment::whereHas('PaymentStatus', function ($query) {
                $query->where('name','Pendiente');
            })->get();

            return view('payment.pendant')->with(['pendantPayments' => $pendantPayments]);
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al mostrar los pagos pendientes');
        }
        

    }


}
