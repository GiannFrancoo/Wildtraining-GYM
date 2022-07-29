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

    <!-- Cards -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">{{ __('Espacio') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Espacio</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payments table -->
    <div class="row">        
        <div class="col mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-danger">{{ __('Lista de pagos') }}</h6>
                    <a href="{{route('payment.create')}}" type="button" class="btn btn-dark" title="add" method="GET" data-toggle="tooltip"><i class="fa fa-add mr-1"></i>{{ __('Nuevo') }}</a>    
                </div> 
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover text-center" id="dataTable">    
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Precio</th>
                                <th>Fecha</th>
                                <th>Subscripcion</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                                <th>Cambiar estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    @if($payment->userSubscription->user != NULL)
                                        <td>{{ $payment->userSubscription->user->getFullNameAttribute() }}</td>
                                    @endif
                                    <th scope="row">${{ $payment->price }}</th>
                                    <td>{{ $payment->date->format('d/m/Y') }}</td>                           
                                    <td>{{ $payment->userSubscription->subscription->name }}</td>
                                    <td>{{ $payment->paymentStatus->name }}</td>
                                    <td class="text-center d-flex justify-content-center">                                    
                                        <a href="{{ route('payment.edit', ['payment_id' => $payment->id]) }}" type="button" class="btn btn-circle btn-secondary" title="Edit" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
                                        <div>
                                            <form action="{{ route('payment.destroy', ['payment_id' => $payment->id]) }}" method="POST"> 
                                                @csrf 
                                                @method("DELETE") 
                                                <button type="submit" class="btn btn-circle btn-danger ml-2" onclick="return confirm('¿Desea borrar pago seleccionado?')" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></button> 
                                            </form>  
                                        </div>                          
                                    </td>  
                                    <td>  
                                        <form action="{{ route('payment.changeStatus', ['payment_id' => $payment->id]) }}" method="GET">
                                            <select class="custom-select" style="text-align:center;" onChange="this.form.submit()" name="new_payment_status_id" value="old(new_payment_status_id)">                                           
                                                @foreach($paymentStatuses as $paymentStatus)    
                                                    <option value="{{ $paymentStatus->id }}"  {{($payment->paymentStatus->id === $paymentStatus->id) ? 'Selected' : ''}}>{{ $paymentStatus->name }}</option>
                                                @endforeach
                                            </select>   
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

@section('custom_js')
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable()
    })
</script>
@endsection