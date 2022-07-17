@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Subscripciones') }}</h1>

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

    <!-- Card view 
    <div class="row">
        @foreach ($subscriptions as $subscription) 
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">                            
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{$subscription->name}}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Veces por semana: {{$subscription->times_a_week}}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Precio mensual: ${{$subscription->month_prince}}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Fecha de modificación: {{$subscription->modification_date}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>
    -->
    
    <!-- Subscriptions table -->
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
                    <form method="POST" action="{{ route('subscription.destroy',['subscription_id' => $subscription->id]) }}">
                        @method('delete')
                        @csrf
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
                                            <td>{{ $subscription->modification_date }}</td>                                
                                            <td>
                                                <a href="" type="button" class="btn btn-secondary" title="Edit" data-toggle="tooltip"><i class="fa fa-eraser mx-1"></i></a>
                                                <!-- <a href="route('profile.destroy')" type="button" class="btn btn-danger" onclick="return confirm('¿Desea borrar la subscripción: {{$subscription->name}}?')" title="Delete" data-toggle="tooltip"><i class="fa fa-trash mx-1"></i></a> -->
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Desea borrar la subscripción: {{$subscription->name}}?')" title="Delete" data-toggle="tooltip"><i class="fa fa-trash mx-1"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </table>
                    </form>
                </div>


            </div>
        </div>
    </div>







@endsection
