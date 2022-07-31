<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payment\PaymentStoreRequest;
use App\Http\Requests\Payment\PaymentUpdateRequest;
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
            $payments = Payment::orderBy('date','desc')->get();
            return view('payment.index')
                ->with([
                    'payments' => $payments,
                    'paymentStatuses' => PaymentStatus::all(),
                ]);
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
    public function create($profile_id = null)
    {   
        try{
            $paymentStatuses = PaymentStatus::all();
            $users = User::whereHas('lastSubscription')->get();
            $userSelected = null;
            $subscription = null;

            if (isset($_GET['user']) && ($_GET['user'] != 'withoutUser') || $profile_id != null) { 
                if($profile_id != null){
                    $userSelected = User::with('lastSubscription')->find($profile_id);
                }
                else{
                    $userSelected = User::with('lastSubscription')->find($_GET['user']);
                }
                
                $subscription = $userSelected->lastSubscription->first();
                
                if (is_null($subscription)) {
                    return redirect()
                        ->back()
                        ->withErrors('El usuario no tiene ninguna suscripción activa');
                }
            }

            return view('payment.create')->with([
                'users' => $users,
                'paymentStatuses' => $paymentStatuses,
                'userSelected' => $userSelected,
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
    public function store(PaymentStoreRequest $request, $payment_id)
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
    public function update(PaymentUpdateRequest $request, $payment_id)
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
            $payment = Payment::findOrFail($payment_id);
            $payment->delete();

            return redirect()
                ->back()
                ->withSuccess('Se elimino con exito el pago');
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
     * List of pending payments
     */
    public function pending()
    {
        try{
            $pendingPayments = Payment::whereHas('PaymentStatus', function ($query) {
                $query->where('id', PaymentStatus::PENDING);
            })->orderBy('date','desc')->get();

            return view('payment.pending')
                ->with(['pendingPayments' => $pendingPayments]);
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al mostrar los pagos pendientes');
        }      
    }

    /**
     * Change the status to a payment
     */
    public function changeStatus(Request $request, $payment_id)
    {
        try{        
            $payment = Payment::findOrFail($payment_id);
            if (isset($_GET['paymentStatusSelect'])){
                $payment->payment_status_id = $_GET['paymentStatusSelect'];
                $payment->payment_status_updated_at = now();
                $payment->save();
                return redirect()->route('home')->withSuccess('Se actualizo el estado del pago correctamente');
            }
            else{
                $payment->payment_status_id = $request->new_payment_status_id;
                $payment->payment_status_updated_at = now();
                $payment->save();
            }
            
                       

            return redirect()->route('payment.index')->withSuccess("Se cambio el estado del pago correctamente");
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al seleccionar usuario');
        }
    }   
}
