@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Panel administrativo</h1>

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

    <!-- Card headers -->
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="d-flex justify-content-between">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" id="ganancia">Ganancia estimada (Mensual)</div>
                                <a data-toggle="collapse" data-target="#collapseMonthlyRevenue" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-eye"></i></a>
                            </div>
                            <div class="row collapse" id="collapseMonthlyRevenue">    
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($monthlyRevenue, 2, '.',',') }}</div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Ganancia estimada (Anual)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($monthlyRevenue*12, 2, '.',',') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pendiente a pago</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <!-- Total Users -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Usuarios   -   Sin suscripción</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users->count() }}   -   {{ $usersWithoutSubscription }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="mb-4">

    <!-- Last payments table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Ultimos pagos agregados') }}</h6>
                    <a href="{{ route('payment.create') }}" type="button" class="btn btn-success" title="add" method="GET" data-toggle="tooltip"><i class="fa fa-add mr-1"></i>Generar nuevo pago</a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover text-center" id="myTable">    
                        <thead>
                            <tr>
                                <th>Nombre y apellido</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Suscripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>{{ $payment->userSubscription->user->getFullNameAttribute() }}</td>
                                    <td>{{ $payment->date->format('d/m/Y') }}</td>
                                    <td>{{ $payment->paymentStatus->name }}</td>
                                    <td>{{ $payment->userSubscription->subscription->name }}</td>
                                    <td>
                                        <!-- deberia cambiar el estado del pago -->
                                        <a href="#" type="button" class="btn btn-secondary mx-1" title="changeStatus" data-toggle="tooltip"><i class="fa fa-pencil mx-1"></i></a>
                                        <form action="{{ route('payment.destroy', ['payment_id' => $payment->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method("DELETE")
                                            <button class="btn btn-danger" onclick="return confirm('¿Desea borrar el pago asociado a {{ $payment->userSubscription->user->getFullNameAttribute() }}?')" title="Delete" data-toggle="tooltip"><i class="fa fa-trash mx-1"></i></button>
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

    <hr class="mb-4">

    <!-- Last users table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Ultimos usuarios agregados') }}</h6>
                    <a href="{{ route('profile.create') }}" type="button" class="btn btn-success" title="add" method="GET" data-toggle="tooltip"><i class="fa fa-add mr-1"></i>Agregar</a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover text-center" id="myTable">    
                        <thead>
                            <tr>
                                <th>Nombre y apellido</th>
                                <th>Telefono</th>
                                <th>Suscripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users->take(5) as $user)
                                <tr>
                                    <td>{{ $user->getFullNameAttribute() }}</td>
                                    <td>{{ $user->primary_phone }}</td>
                                    <td>
                                        @if ($user->lastSubscription->isEmpty())
                                            Sin suscripción
                                        @else
                                            {{ $user->lastSubscription->first()->name }}                                               
                                        @endif 
                                    </td>
                                    <td>
                                        <a href="{{route('profile', ['profile_id' => $user->id])}}" type="button" class="btn btn-primary mx-1"><i class="fa fa-eye"></i></a>
                                        <a href="{{route('profile.edit', ['profile_id' => $user->id])}}" type="button" class="btn btn-secondary mx-1" title="Edit" data-toggle="tooltip"><i class="fa fa-pencil mx-1"></i></a>
                                        <form action="{{ route('profile.destroy', ['profile_id' => $user->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method("DELETE")
                                            <button class="btn btn-danger" onclick="return confirm('¿Desea borrar al usuario {{ $user->name }}?')" title="Delete" data-toggle="tooltip"><i class="fa fa-trash mx-1"></i></button>
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
        $('table').DataTable()
    })
</script>
@endsection