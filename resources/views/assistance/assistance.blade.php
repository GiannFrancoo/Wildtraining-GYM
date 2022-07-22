@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h1 class="h3 mb-4 text-gray-800">{{ __('Asistencias') }}</h1>
        <div>
            <a href="{{route('assistance.create')}}" class="btn btn-success mr-1"><i class="fa fa-add mr-1"></i>Marcar nueva asistencia</a>    
        </div>        
    </div>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Cards -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Hora pico de asistencias</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ ($busiestHour == 0) ? 0 : $busiestHour }}:00</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Asistencias de hoy : {{ now()->format('d-m-Y')}}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">In progress...</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assistances table  -->
    <div class="row">
        <div class="col mb-4">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-lg-8 col-md-6 my-2">
                            <h6 class="m-0 font-weight-bold text-primary">Lista de asistencias</h6>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <input type="text" id="myInput" onkeyup="tableSearch()" class="form-control" placeholder="Fecha de la asistencia&hellip;">
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table-reponsive">
                        <table class="table table-bordered table-hover text-center" id="myTable">    
                            <thead>
                                <tr>
                                    <th scope="col">Usuario<i class="fa fa-user ml-1"></i></th>
                                    <th scope="col">Fecha<i class="fa fa-calendar ml-1"></i></th>
                                    <th scope="col">Hora<i class="fa fa-clock-o ml-1"></i></th>
                                    <th scope="col">Acciones<i class="fa fa-server ml-1"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assistances as $assistance)
                                    <tr>
                                        <td>{{ $assistance->user->getFullNameAttribute() }}</td>
                                        <td>{{ $assistance->date->format('d-m-Y') }}</td>
                                        <td>{{ $assistance->date->format('H:i:s') }}</td>
                                        <td>
                                            <a href="{{ route('assistance.edit', ['assistance_id' => $assistance->id]) }}" type="button" class="btn btn-primary" title="Edit" data-toggle="tooltip"><i class="fa fa-pencil mx-1"></i></a>
                                            
                                            <form method="POST" action="{{ route('assistance.destroy', ['assistance_id' => $assistance->id]) }}" class="d-inline">  
                                                @csrf    
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Desea borrar la assistencia de: {{ $assistance->user->getFullNameAttribute() }}?')" title="Delete" data-toggle="tooltip"><i class="fa fa-trash mx-1"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </table>
                </div>
            </div>
        </div>
    </div>
   
@endsection