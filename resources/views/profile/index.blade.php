@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Usuarios</h1>


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

    <!-- Card headers -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1" id="ganancia">Total</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Average ages> -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Promedio de edad</div>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $averageAges }} Años</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-hourglass fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Womens -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">{{ __('Mujeres') }}</div>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $users->count() - $menUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-venus fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mens -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ __('Hombres') }}</div>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $menUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-mars fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- User table -->
    <div class="row">
        <div class="col mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Lista de usuarios') }}</h6>
                    <a href="{{route('profile.create')}}" type="button" class="btn btn-success" title="add" method="GET" data-toggle="tooltip"><i class="fa fa-add mr-1"></i>Agregar</a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover text-center" id="dataTable">    
                        <thead>
                            <tr>
                                <th>Nombre y apellido</th>
                                <th>Telefono</th>
                                <th>Fecha de inicio</th>
                                <th>Suscripcion</th>
                                <th>Acciones</th>
                                <th>Cambiar suscripcion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->getFullNameAttribute() }}</td>
                                    <td>{{ $user->primary_phone }}</td>
                                    <td>{{ $user->start_date->format('d/m/Y') }}</td>
                                    @if($user->lastSubscription()->first() != null)
                                        <td>{{ $user->lastSubscription()->first()->name}}</td>
                                    @else
                                        <td>{{ __('Sin suscripcion') }}</td>
                                    @endif
                                    <td class="d-flex justify-content-center">
                                        <a href="{{ route('profile.edit', ['profile_id' => $user->id]) }}" type="button" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                        <div class="ml-3">
                                            <form action="{{ route('profile.destroy', ['profile_id' => $user->id]) }}" method="POST">
                                                @csrf
                                                @method("DELETE")
                                                <button class="btn btn-danger" onclick="return confirm('¿Desea borrar al usuario {{$user->name}}?')"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>  
                                    <td>  
                                        <form action="{{ route('profile.updateSubscription', ['profile_id' => $user->id]) }}" method="GET" >
                                            @if($user->lastSubscription()->first() != null)
                                                <select class="custom-select" style="text-align:center;" onChange="this.form.submit()" name="newSubscription_id" value="">                                           
                                                @foreach($subscriptions as $subscription)    
                                                    <option value="{{ $subscription->id }}"  {{($user->lastSubscription()->first()->id === $subscription->id) ? 'Selected' : ''}}>{{ $subscription->name }}</option>
                                                @endforeach
                                                    <option value="sinSubscripcion"> Sin suscripcion </option>
                                                </select>                                   
                                            @else
                                                <select class="custom-select" style="text-align:center;" onChange="this.form.submit()" name="newSubscription_id" value="">                                           
                                                    <option selected value="sinSubscripcion"> Sin suscripcion </option>
                                                    @foreach($subscriptions as $subscription)    
                                                        <option value="{{ $subscription->id }}">{{ $subscription->name }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
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
        $('#dataTable').DataTable( {
            order: [[0, 'asc']],
        })
    })
</script>
@endsection