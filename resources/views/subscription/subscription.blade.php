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

    <div class="row">
        @foreach ($subscriptions as $subscription) 
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="font-weight-bold">{{ $subscription->name }}</h5>
                    <div>
                        <a href="#" class="btn btn-success mr-1">A</a>
                        <a href="#" class="btn btn-success">B</a>
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endforeach

    </div>
    
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
                                                <!-- <a href="route('profile.destroy')" type="button" class="btn btn-danger" onclick="return confirm('¿Desea borrar la subscripción: {{$subscription->name}}?')" title="Delete" data-toggle="tooltip"><i class="fa fa-trash mx-1"></i></a> -->
                                                
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
@endsection
