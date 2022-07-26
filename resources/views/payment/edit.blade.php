@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Pago') }}</h1>

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
        <form method="POST" action="{{ route('payment.update', ['payment_id' => $payment->id]) }}">
        @csrf
        @method('PUT')
        
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Editando el pago</h6>
                </div>

                <div class="card-body row">   
                                            
                    <div class="col-md-6">
                        <div class="form-group focused">
                            <label class="form-control-label" for="price">Precio<span class="small text-danger">*</span></label>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>  
                                </div>                          
                                <input type="number" id="price" class="form-control" required name="price" value="{{ old('price', $payment->price) }}">
                            </div>
                        </div>
                    </div> 

                    <div class="col-md-6">
                        <div class="form-group focused">
                            <label class="form-control-label" for="date">Fecha<span class="small text-danger">*</span></label>
                            <input type="datetime-local" id="date" required class="form-control" name="date" placeholder="now()" value="{{ old('date', $payment->date->format('Y-m-d H:i:s'))}}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="userPayment">Usuario que pago</label>
                            <input readonly type="text" id="userPayment" class="form-control" name="userPayment" value="{{ old('name', $payment->userSubscription->user->name) }}">                                  
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="userSubscription">Subscripcion</label>
                            <input readonly type="text" id="userSubscription" class="form-control" name="userSubscription" value="{{ old('name', $payment->userSubscription->subscription->name) }}">                                  
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group focused">
                            <label class="form-control-label" for="paymentStatus">Estado del pago</label>
                            <select class="custom-select" name="paymentStatus" value="{{ old('$payment->paymentStatus->name') }}">                                           
                                @foreach($paymentsStatuses as $paymentStatus)
                                    <option value="{{ $paymentStatus->id }}" {{($payment->paymentStatus->id === $paymentStatus->id) ? 'Selected' : ''}}>{{ $paymentStatus->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>                        
                </div>

                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-disk mr-1"></i>Guardar cambios</button>
                </div>

            </div>

        </form>
    </div>



@endsection
