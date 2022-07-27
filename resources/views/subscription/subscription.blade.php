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

    <!-- Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{__('Cantidad suscripciones')}}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $subscriptions->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-square-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <hr class="py-2">

    <!-- Card with subscriptions -->
    <div class="row">
        @foreach ($subscriptions as $subscription)
            @if($subscription->name != 'No posee')
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="font-weight-bold">{{ $subscription->name }}</h5>
                            <div class="row">                        
                                <a href="{{ route('subscription.edit', ['subscription_id' => $subscription->id]) }}" class="btn btn-primary mr-1"><i class="fa fa-pencil mr-1"></i>Editar</a>
                                <form action="{{ route('subscription.destroy', ['subscription_id' => $subscription->id]) }}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn btn-danger mr-1" type="submit" onclick="return confirm('Desea eliminar esta subscripción y con ella todos los alumnos subscriptos?')"><i class="fa fa-trash mr-1"></i>Eliminar</button>
                                </form>
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
                                        <td class="text-right">{{ $subscriptionArray[$subscription->id] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('subscription.show', ['subscription_id' => $subscription->id]) }}" class="btn btn-success"><i class="fa fa-users mr-1"></i>Ver inscriptos</a>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
        
@endsection