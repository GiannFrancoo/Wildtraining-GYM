@extends('layouts.admin')

@section('main-content')



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

<h1>Pagos</h1>
<br>

    <div class="row">
        <div class="col mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-lg-8 col-md-6 my-2">
                            <h6 class="m-0 font-weight-bold text-primary">Lista de pagos</h6>
                        </div>
                        <div class="col-lg-1 col-md-2 col-sm-3" style="flight: right;">
                            <a href="{{route('payment.users')}}" type="button" id="buttonModal" style="flight: right;" class="btn btn-success float-right" title="add" method="GET" data-toggle="tooltip"><i class="fa-solid fa fa-money"></i>Agregar</a>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                




                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center" id="myTable">    
                            <thead>
                                <tr>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Hora</th>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Subscripcion</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    <tr>
                                        <th scope="row">${{ $payment->price }}</th>
                                        <td>{{ $payment->date->format('d-m-Y') }}</td>
                                        <td></td>
                                        <td>{{$payment->userSubscription->subscription->name}}</td>
                                        @if($payment->userSubscription->user != NULL)
                                            <td>{{$payment->userSubscription->user->name}}</td>
                                        @endif
                                        <td class="text-center">
                                            <a href="{{route('payment.edit', ['payment_id' => $payment->id])}}" type="button" class="btn btn-secondary" title="Edit" data-toggle="tooltip"><i class="fa fa-eraser mx-1"></i></a>
                                            <form action="{{ route('payment.destroy', ['payment_id' => $payment->id]) }}" method="POST"> 
                                                @csrf 
                                                @method("DELETE") 
                                                <button class="btn btn-danger" onclick="return confirm('¿Desea borrar pago seleccionado?')" title="Delete" data-toggle="tooltip"><i class="fa fa-trash mx-1"></i></button> 
                                            </form>
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