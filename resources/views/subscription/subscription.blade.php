@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h1 class="h3 mb-4 text-gray-800">{{ __('Planes') }}</h1>
        <div>
            <a href="{{route('subscription.create')}}" class="btn btn-dark mr-1"><i class="fa fa-add mr-1"></i>Agregar</a>    
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

   
    <hr class="py-2">

    <!-- Card with subscriptions -->
    <div class="row">
        @foreach ($subscriptions as $subscription)
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="h4 mb-4 text-gray-800">{{ $subscription->name }}</h5>
                        <div class="row">                        
                            <a href="{{ route('subscription.edit', ['subscription_id' => $subscription->id]) }}" class="btn btn-secondary btn-circle mr-1"><i class="fa fa-pencil"></i></a>
                            <form action="{{ route('subscription.destroy', ['subscription_id' => $subscription->id]) }}" method="POST">
                                @csrf
                                @method("DELETE")
                                <button class="btn btn-danger btn-circle mx-2" type="submit" onclick="return confirm('¿Desea eliminar este plan y con ella todos los alumnos?')"><i class="fa fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
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
                        <a href="{{ route('subscription.show', ['subscription_id' => $subscription->id]) }}" class="btn btn-dark"><i class="fa fa-users mr-1"></i>Inscriptos</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
        
@endsection