<?php

namespace App\Http\Controllers;

use App\Http\Requests\Assistance\AssistanceStoreRequest;
use App\Http\Requests\Assistance\AssistanceUpdateRequest;
use App\Models\Assistance;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AssistanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assistances = Assistance::whereHas('user')->orderBy('date','DESC')->get();
        $bussiestHours = ["hour" => 0, "count" => 0];
        $todayAssists = 0;



        $hours = $assistances
                ->groupBy(function ($assistance) {
                    return $assistance->date->format('H');
                })
                ->map(function ($assistance, $hour) {
                    return [
                        "hour" => $hour,
                        "count" => $assistance->count()
                    ];
                })
                ->sortByDesc('hour')
                ->toArray();
        
        // $hours->toArray();
        // dd($hours);


        if ($assistances->isEmpty()){
            $bussiestHours = ["hour" => 0, "count" => 0];
            $todayAssists = 0;        
        }
        else{
            $bussiestHours = $assistances
                ->groupBy(function ($assistance) {
                    return $assistance->date->format('H');
                })
                ->map(function ($assistance, $hour) {
                    return [
                        "hour" => $hour,
                        "count" => $assistance->count()
                    ];
                })
                ->sortByDesc('count')
                ->first();

            $todayAssists = $assistances
                ->filter(function ($assist) {
                    return $assist->date->isToday();
                })
                ->count();
        }
                    
        return view('assistance.assistance')->with([
            'assistances' => $assistances,
            'bussiestHours' => $bussiestHours['hour'],
            'todayAssists' => $todayAssists,
            'hours' => $hours,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('assistance.create')->with('users', $users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssistanceStoreRequest $request)
    {
        try{       
            $assistance = new Assistance();
            $assistance->user_id = User::findOrFail($request->user_id)->id;
            $assistance->date = $request->date;
            
            $assistance->save();

            return redirect()->route('assistance.index')->withSuccess('Asistencia registrada correctamente');
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al registrar la asistencia');
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
        //not necessary
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
            $assistance = Assistance::findOrFail($id);
            $users = User::all();
            return view('assistance.edit')->with(['assistance' => $assistance, 'users' => $users]);
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al editar una asistencia');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AssistanceUpdateRequest $request, $id)
    {
        try{
            $assistance = Assistance::findOrFail($id);
            $assistance->user_id = User::findOrFail($request->user_id)->id;;
            $assistance->date = $request->date;
            
            $assistance->save();
            return redirect()->route('assistance.index')->withSuccess('Asistencia modificada correctamente');
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al editar la asistencia');
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
            $assistance = Assistance::findOrFail($id);            
            $assistance->delete();

            return redirect()->route('assistance.index')->withSuccess('Se elimino la asistencia correctamente');
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Error al eliminar la asistencia');
        }
    }
}