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

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- User profile -->
    <div class="row">
        <div class="col-md-8 mb-3">     
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="h4 text-gray-800">Usuario: {{ $user->getFullNameAttribute() }}</h5>
                    <div class="d-flex justify-content-between">                        
                        <a href="{{ route('profile.edit', ['profile_id' => $user->id]) }}" class="btn btn-secondary"><i class="fa fa-pencil mr-1"></i>{{ __('Editar') }}</a>
                        <form action="{{ route('profile.destroy', ['profile_id' => $user->id]) }}" method="POST">
                            @csrf
                            @method("DELETE")
                            <button class="btn btn-danger ml-2" type="submit" onclick="return confirm('Desea eliminar esta subscripción y con ella todos los alumnos subscriptos?')"><i class="fa fa-trash mr-1"></i>{{ __('Eliminar') }}</button>
                        </form>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td>Email:</td>
                                <td class="text-right">{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td>Celular:</td>
                                <td class="text-right">{{ $user->primary_phone }}</td>
                            </tr>
                            <tr>
                                <td>Celular secundario:</td>
                                @if ($user->secondary_phone != null)
                                    <td class="text-right">{{ $user->secondary_phone }}</td>
                                @else
                                    <td class="text-right"> - </td>
                                @endif
                            </tr>
                            <tr>
                                <td>Dirección:</td>
                                @if ($user->address != null)
                                    <td class="text-right">{{ $user->address }}</td>
                                @else
                                    <td class="text-right"> - </td>
                                @endif
                            </tr>
                            <tr>
                                <td>Fecha de nacimiento:</td>
                                @if ($user->birthday != null)
                                    <td class="text-right">{{ $user->birthday->format('d/m/Y') }} - ({{ $user->getAge() }} años)</td>
                                @else
                                    <td class="text-right"> - </td>
                                @endif
                            </tr>
                            <tr>
                                <td>Fecha de inicio:</td>
                                <td class="text-right">{{ $user->start_date->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td>Obra social:</td>
                                <td class="text-right">{{ $user->social_work }}</td>
                            </tr>
                            <tr>
                                <td>Plan:</td>
                                @if ($user->lastSubscription->first() != null)
                                    <td class="text-right">{{ $user->lastSubscription->first()->name }}</td>
                                @else
                                    <td class="text-right"> No tiene plan </td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-header text-center align-items-center">
                    <h4 class="h5 text-gray-800"><i class="fa fa-circle-info mr-1"></i>Información personal</h4>    
                </div>
                <div class="card-body">
                    <p>{{ $user->personal_information }}</p>
                </div>
            </div>   

        </div>
        
    </div>
    
    <hr>

    <!-- Payments historial -->
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-danger">{{ __('Historial de pagos del usuario') }}</h6>
                    <a href="{{ route('payment.create', ['profile_id' => $user->id]) }}" type="button" class="btn btn-dark" title="add" method="GET" data-toggle="tooltip"><i class="fa fa-add mr-1"></i>{{ __('Nuevo pago') }}</a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover text-center" id="dataTable">    
                        <thead>
                            <tr>
                                <th>Abonado</th>
                                <th>Fecha</th>
                                <th>Plan</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>                        
                            @foreach ($userPayments as $payment)  
                                <tr>                               
                                    <td>${{ $payment->price }}</td>
                                    <td>{{ $payment->date->format('d/m/Y') }}</td>
                                    <td>{{ $payment->userSubscription->subscription->name }}</td>
                                    <td><h5><span class="badge badge-pill badge-{{$payment->paymentStatus->color}}">{{ $payment->paymentStatus->name }}</span></h5></td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('payment.edit', ['payment_id' => $payment->id]) }}" type="button" class="btn btn-circle btn-secondary" title="edit" method="GET" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
                                            <form action="{{ route('payment.destroy', ['payment_id' => $payment->id]) }}" method="POST">
                                            @csrf
                                            @method("DELETE")
                                                <button class="btn btn-danger btn-circle mx-2" type="submit" onclick="return confirm('¿Desea eliminar este pago?')"><i class="fa fa-trash"></i></button>
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

    <hr>

    <!-- Subscription historial -->
    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-danger">{{ __('Historial de planes del usuario') }}</h6>
                    <a href="{{ route('profile.changeSubscription', ['profile_id' => $user->id]) }}" type="button" class="btn btn-dark" title="add" method="GET" data-toggle="tooltip"><i class="fa fa-add mr-1"></i>{{ __('Cambiar plan') }}</a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover text-center" id="dataTable">    
                        <thead>
                            <tr>
                                <th>Plan</th>
                                <th>Fecha de modificación</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userSubscriptions as $userSubscription)
                                <tr>                               
                                    <td>{{ $userSubscription->subscription->name }}</td>
                                    <td data-order="Ymd">{{ $userSubscription->user_subscription_status_updated_at->format('d/m/Y') }}</td>
                                    <td><h5><span class="badge badge-pill badge-{{$userSubscription->status->color}}">{{ $userSubscription->status->name }}</td>                                
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
        $('#dataTable').DataTable({
            order: [1, 'desc'],
        })
    })
</script>
@endsection