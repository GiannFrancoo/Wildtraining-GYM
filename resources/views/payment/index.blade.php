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

 <div clas="row"></div>   
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
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a href="{{route('payment.users')}}" class="btn btn-success mr-1" data-toggle="tooltip"><i class="fa-solid fa fa-money"></i>Agregar</a>
                                </div>
                            </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <input type="text" id="myInput" onkeyup="tableSearch()" class="form-control" placeholder="Nombre de usuario&hellip;">
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                




                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center" id="myTable">    
                            <thead>
                                <tr>
                                    <th scope="col"><i class="fa fa-user" aria-hidden="true"></i></th>
                                    <th scope="col"><i class="fa fa-money" aria-hidden="true"></i></th>
                                    <th scope="col"><i class="fa fa-calendar" aria-hidden="true"></i></th>
                                    <th scope="col"><i class="fa fa-clock-o" aria-hidden="true"></i></th>
                                    <th scope="col"><i class="fa fa-address-card" aria-hidden="true"></i></th>
                                    <th scope="col"><i class="fa fa-tasks" aria-hidden="true"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    <tr>
                                        @if($payment->userSubscription->user != NULL)
                                            <td>{{$payment->userSubscription->user->name}}</td>
                                        @endif
                                        <th scope="row">${{ $payment->price }}</th>
                                        <td>{{ $payment->date->format('d-m-Y') }}</td>
                                        <td>{{$payment->date->format('H:i:s')}}</td>
                                        
                                        <td>{{$payment->userSubscription->subscription->name}}</td>
                                        <div class="row">
                                            <td class="text-center">
                                                <a href="{{route('payment.edit', ['payment_id' => $payment->id])}}" type="button" class="btn btn-secondary" title="Edit" data-toggle="tooltip"><i class="fa fa-eraser mx-1"></i></a>
                                                <div>
                                                <form action="{{ route('payment.destroy', ['payment_id' => $payment->id]) }}" method="POST"> 
                                                    @csrf 
                                                    @method("DELETE") 
                                                    <button class="btn btn-danger" onclick="return confirm('¿Desea borrar pago seleccionado?')" title="Delete" data-toggle="tooltip"><i class="fa fa-trash mx-1"></i></button> 
                                                </form>
                                                </div>   
                                            </td>
                                        </div>
                                    </tr>
                                @endforeach
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection