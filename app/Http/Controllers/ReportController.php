<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentStatus;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Date;

class ReportController extends Controller
{
    
    public function indexMonth()
    {
        return view('report.index_month');
    }

    public function showMonth(Request $request)
    {
        try{
            $months = array(12);
            for($numberMonth = 0; $numberMonth < 12; $numberMonth++){
                $months[$numberMonth] = (date('F', mktime(0, 0, 0, ($numberMonth+1), 10)));
            };
            
            $initDate = Carbon::createFromDate($request->year, $request->month, 1)->firstOfMonth();
            $endDate = Carbon::createFromDate($request->year, $request->month, 1)->endOfMonth();
            $payments = Payment::whereBetween('date', [$initDate, $endDate])->get();
            $paymentStatuses = PaymentStatus::all();
            $paymentGenerated =  $payments->sum('price');
            $cantNewUsers = User::whereBetween('start_date', [$initDate, $endDate])->get()->count();

            return view('report.show_month')
            ->with([
                'months' => $months,
                'payments' => $payments,
                'selectedDate' => 1,
                'paymentStatuses' => $paymentStatuses,
                'paymentGenerated' => $paymentGenerated,
                'cantNewUsers' => $cantNewUsers
            ]);
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('No se encuentran registros en la fecha indicada'); 
        }
    }

    public function indexYear()
    {
        return view('report.index_year');
    }

    public function showYear(Request $request)
    {
        try{
            $months = array(12);
            for($numberMonth = 0; $numberMonth < 12; $numberMonth++){
                $months[$numberMonth] = (date('F', mktime(0, 0, 0, ($numberMonth+1), 10)));
            };
            
            $initDate = Carbon::createFromDate($request->year, 1, 1)->firstOfYear();
            $endDate = Carbon::createFromDate($request->year, 1, 1)->endOfYear();
            $payments = Payment::whereBetween('date', [$initDate, $endDate])->get(); //agrupar por mes?
            $paymentStatuses = PaymentStatus::all();
            $paymentGenerated =  $payments->sum('price');
            $cantNewUsers = User::whereBetween('start_date', [$initDate, $endDate])->get()->count();

            return view('report.show_year')
            ->with([
                'year' => $request->year,
                'months' => $months,
                'payments' => $payments,
                'paymentStatuses' => $paymentStatuses,
                'paymentGenerated' => $paymentGenerated,
                'cantNewUsers' => $cantNewUsers
            ]);
        }
        catch(Exception $e){
            dd($e->getMessage());
            return redirect()->back()->withErrors('No se encuentran registros en la fecha indicada'); 
        }
    }


}
