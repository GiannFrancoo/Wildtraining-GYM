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
    //
    public function index(Request $request)
    {
        try{
            $selectedDate = null;
            $months = array(12);
            for($numberMonth = 0; $numberMonth < 12; $numberMonth++){
                $months[$numberMonth] = (date('F', mktime(0, 0, 0, ($numberMonth+1), 10)));
            };

            if(isset($_GET['btnSearch'])){
                $initDate = Carbon::createFromDate($request->year, $request->month, 1)->firstOfMonth();
                $endDate = Carbon::createFromDate($request->year, $request->month, 1)->endOfMonth();
                $payments = Payment::whereBetween('date', [$initDate, $endDate])->get();
                
                $statusesPayments = PaymentStatus::all();
                return view('report.month')
                ->with([
                    'months' => $months,
                    'payments' => $payments,
                    'selectedDate' => 1,
                    'statusesPayments' => $statusesPayments
                ]);
            }

            return view('report.month')
            ->with([
                'months' => $months,
                'selectedDate' => $selectedDate
            ]);
        }
        catch(Exception $e){
            dd($e->getMessage());
            return redirect()->back()->withErrors('No se encuentran registros en la fecha indicada'); 
        }
    }

    public function showMonth()
    {
        
    }
}
