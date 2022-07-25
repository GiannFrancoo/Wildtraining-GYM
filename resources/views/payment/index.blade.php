@extends('layouts.admin')

@section('main-content')

    <!-- Header -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Pagos') }}</h1>      
    

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success border-left-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <!-- Payments table -->
    <div class="row">
        
        <div class="col mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Lista de pagos</h6>
                    <a href="{{route('payment.create')}}" type="button" class="btn btn-success" title="add" method="GET" data-toggle="tooltip"><i class="fa fa-add mr-1"></i>Agregar</a>    
                </div> 


                <div class="card-header py-3 col-lg-4">
                    <input type="text" id="myInput" onkeyup="tableSearch()" class="form-control" placeholder="Nombre de usuario&hellip;">
                </div>
                                     
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center" id="myTable">    
                        <thead>
                            <tr>
                                <th scope="col">Usuario</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Fecha</th>
                                <th scope="col"><i class="fa fa-clock-o" aria-hidden="true"></i></th>
                                <th scope="col">Subscripcion</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    @if($payment->userSubscription->user != NULL)
                                        <td>{{ $payment->userSubscription->user->name }}</td>
                                    @endif
                                    <th scope="row">${{ $payment->price }}</th>
                                    <td>{{ $payment->date->format('d-m-Y') }}</td>
                                    <td>{{ $payment->date->format('H:i:s') }}</td>                                
                                    <td>{{ $payment->userSubscription->subscription->name }}</td>
                                    <td class="text-center d-flex justify-content-center">                                    
                                        <a href="{{ route('payment.edit', ['payment_id' => $payment->id]) }}" type="button" class="btn btn-secondary" title="Edit" data-toggle="tooltip"><i class="fa fa-eraser mx-1"></i></a>
                                        <div class="mx-1">
                                            <form action="{{ route('payment.destroy', ['payment_id' => $payment->id]) }}" method="POST"> 
                                                @csrf 
                                                @method("DELETE") 
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Desea borrar pago seleccionado?')" title="Delete" data-toggle="tooltip"><i class="fa fa-trash mx-1"></i></button> 
                                            </form>  
                                        </div>                          
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

@endsection