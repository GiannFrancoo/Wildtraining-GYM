<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\PaymentStatus;
use App\Models\UserSubscription;
use App\Models\UserSubscriptionStatus;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\Payment\PaymentStoreRequest;
use App\Http\Requests\Payment\PaymentUpdateRequest;

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
            $monthlyRevenue = 0;
            $users = User::has('lastSubscription')
                ->with('lastSubscription')
                ->get();

            foreach ($users as $user) {
                $monthlyRevenue = $monthlyRevenue + $user->lastSubscription->first()->month_price;
            }      

            $payments = Payment::orderBy('date','desc')->get();

            $paymentStatuses = PaymentStatus::all();

            return view('payment.index')
                ->with([
                    'payments' => $payments,
                    'paymentStatuses' => $paymentStatuses,
                    'monthlyRevenue' => $monthlyRevenue,
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
            $paymentStatusDefault = PaymentStatus::findOrFail(PaymentStatus::PAID);
           


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
                        ->withErrors('El usuario no tiene ningun plan activo');
                }
            }

            return view('payment.create')->with([
                'users' => $users,
                'paymentStatuses' => $paymentStatuses,
                'userSelected' => $userSelected,
                'subscription' => $subscription,
                'amounthMonthPay' => 1,
                'priceAmounthMonthPay' => null,
                'paymentStatusDefault' => $paymentStatusDefault,
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
    public function store(PaymentStoreRequest $request, $profile_id)
    {
        try{
            if (isset($_POST['btnApply'])) {
                $paymentStatuses = PaymentStatus::all();
                $users = User::has('lastSubscription')->get();
                $userSelected = User::with('lastSubscription')->find($profile_id);
                $subscription = $userSelected->lastSubscription->first();
                $priceAmounthMonthPay = $subscription->month_price * $request->amounthMonthPay;
                $paymentStatusDefault = PaymentStatus::findOrFail($request->paymentStatus);

                return view('payment.create')->with([
                    'users' => $users,
                    'paymentStatuses' => $paymentStatuses,
                    'userSelected' => $userSelected,
                    'subscription' => $subscription,
                    'amounthMonthPay' => $request->amounthMonthPay,
                    'priceAmounthMonthPay' => $priceAmounthMonthPay,
                    'paymentStatusDefault' => $paymentStatusDefault,
                ]);
            }

            $user = User::with('lastSubscription')->findOrfail($profile_id);
            $userSubscription = $user->lastSubscription->first()->pivot;
            $requestDate = new Carbon($request->date);
            $now = Carbon::now();
            for($size = 0; $size < $request->amounthMonthPay; $size++){
                $userSubscription->payments()->create([
                    'user_subscription_id' => $userSubscription->id,
                    'price' => ($request->price / $request->amounthMonthPay),
                    'date' => $requestDate,
                    'payment_status_id' => $request->paymentStatus,
                    'payment_status_updated_at' => $now,
                ]);
                $requestDate->addMonth()->firstOfMonth();     
            }

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

            $paymentStatuses = PaymentStatus::all();

            return view('payment.pending')
                ->with([
                    'pendingPayments' => $pendingPayments,
                    'paymentStatuses' => $paymentStatuses,
                ]);
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al mostrar los pagos pendientes');
        }      
    }

    /**
     * Generate pending payments
     */
    public function generatePendingPayments()
    {  
        $now = Carbon::today();

        try{
            $userSubscriptions = UserSubscription::query()
                ->where('user_subscription_status_id', UserSubscriptionStatus::ACTIVE)
                ->with('subscription', 'payments')
                ->get();
                
            $userSubscriptions->each(function ($userSubscription) use ($now) {
                $payments = $userSubscription->payments
                    ->filter(function ($payment) use ($now) {
                        return (
                            $payment->date->isBetween($now->copy()->firstOfMonth(), $now->copy()->endOfMonth()->endOfDay()) &&
                            $payment->payment_status_id !== PaymentStatus::CANCELLED
                        );
                    });

                if ($payments->isNotEmpty()) {
                    return;
                }

                Payment::create([
                    "user_subscription_id" => $userSubscription->id,
                    "price" => $userSubscription->subscription->month_price,
                    "date" => $now,
                    "payment_status_id" => PaymentStatus::PENDING, 
                    "payment_status_updated_at" => now(),
                ]);
            });
            
            return redirect()->back()->with(['success' => 'Exito al generar los pagos a los usuarios con un plan activo']);
        }
        catch(Exception $e){
            dd($e->getMessage());
            return redirect()->back()->withErrors('Error al generar los pagos, con estado pendiente, a lo usuarios con un plan activa');
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
            
                       

            return redirect()->back()->withSuccess("Se cambio el estado del pago correctamente");
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al seleccionar usuario');
        }
    }
   
}
