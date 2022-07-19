<?php

namespace App\Http\Controllers;

use App\Models\Assistance;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class AssistanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assistances = Assistance::orderBy('date')->get();
        return view('assistance.assistance')->with('assistances', $assistances);
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
    public function store(Request $request)
    {
        try{
            $assistance = new Assistance();
            $assistance->user_id = User::findOrFail($request->user_id)->id;;
            $assistance->date = Carbon::parse($request->date)->format('Y-m-d h:m:s');
            
            $assistance->save();

            return redirect()->route('assistance.index')->withSuccess('Asistencia registrada correctamente');
        }
        catch(Exception $e){
            dd($e->getMessage());
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
            $assistance = Assistance::find($id);
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
    public function update(Request $request, $id)
    {
        try{
            $assistance = Assistance::findOrFail($id);
            $assistance->user_id = User::findOrFail($request->user_id)->id;;
            $assistance->date = Carbon::parse($request->date)->format('Y-m-d h:m:s');
            
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
