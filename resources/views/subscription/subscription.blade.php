@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h1 class="h3 mb-4 text-gray-800">{{ __('Subscripciones') }}</h1>
        <div>
            <a href="{{route('subscription.create')}}" class="btn btn-success mr-1"><i class="fa fa-add mr-1"></i>Agregar</a>    
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

    <!-- Card with subscriptions -->
    <div class="row">
        @foreach ($subscriptions as $subscription) 
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="font-weight-bold">{{ $subscription->name }}</h5>
                    <div class="row">                        
                        <a href="{{ route('subscription.edit', ['subscription_id' => $subscription->id]) }}" class="btn btn-primary mr-1"><i class="fa fa-pencil mr-1"></i>Editar</a>
                        <a href="{{ route('subscription.destroy', ['subscription_id' => $subscription->id]) }}" onclick="return confirm('Desea eliminar esta subscripción y con ella todos los alumnos subscriptos?')" class="btn btn-danger mr-1"><i class="fa fa-trash mr-1"></i>Eliminar</a>
                        <!-- <form action="{{ route('subscription.destroy', ['subscription_id' => $subscription->id]) }}" method="POST">
                            @csrf
                            @method("DELETE")    
                            <button class="btn btn-danger" type="submit"><i class="fa fa-trash mr-1"></i>Eliminar</button>
                        </form> PORQUE TIENE EL METODO GET AHORA -->
                    </div>
                </div>
                <div class="card-body p-1">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td>Veces por semana:</td>
                                <td class="text-right">{{ $subscription->times_a_week }}</td>
                            </tr>
                            <tr>
                                <td>Precio mensual:</td>
                                <td class="text-right">${{ $subscription->month_price }}</td>
                            </tr>
                            <tr>
                                <td>Fecha de modificación:</td>
                                <td class="text-right">{{ $subscription->modification_date->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td>Cantidad inscriptos:</td>
                                <td class="text-right">{{ $subscription->users->count() }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endforeach

    </div>
    
    <hr class="py-2">

    <!-- Cantidad inscriptos total y lo que no tienen plan
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">

                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    Cantidad inscriptos
                </div>
            </div>
        </div>
    </div>
     -->

    <!-- Subscriptions table 
    <div class="row">
        <div class="col mb-4">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-lg-8 col-md-6 my-2">
                            <h6 class="m-0 font-weight-bold text-primary">Lista de subscripciones</h6>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <input type="text" id="myInput" onkeyup="tableSearch()" class="form-control" placeholder="Nombre de subscripcion&hellip;">
                        </div>
                        <div class="col-lg-1 col-md-2 col-sm-3">
                            <a href="#" type="button" class="btn btn-success float-right" title="add" data-toggle="tooltip"><i class="fa-solid fa-circle-plus mx-1"></i>Nuevo</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                        <table class="table-reponsive">
                            <table class="table table-bordered table-hover text-center" id="myTable">    
                                <thead>
                                    <tr>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Veces por semana</th>
                                        <th scope="col">Precio por mes</th>
                                        <th scope="col">Ultima modificación</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subscriptions as $subscription)
                                        <tr>
                                            <td>{{ $subscription->name }}</td>
                                            <td>{{ $subscription->times_a_week }}</td>
                                            <td>${{ $subscription->month_price }}</td>
                                            <td>{{ $subscription->modification_date->format('d/m/Y') }}</td>                                
                                            <td>
                                                <a href="" type="button" class="btn btn-secondary" title="Edit" data-toggle="tooltip"><i class="fa fa-eraser mx-1"></i></a>
                                                
                                                <form method="POST" action="{{ route('subscription.destroy', ['subscription_id' => $subscription->id]) }}" class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Desea borrar la subscripción: {{$subscription->name}}?')" title="Delete" data-toggle="tooltip"><i class="fa fa-trash mx-1"></i></button>
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
    -->
@endsection
