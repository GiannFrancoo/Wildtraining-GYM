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
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" id="ganancia">Total</div>
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
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Promedio de edad</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$averageAges}} Años</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
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
                    <h6 class="m-0 font-weight-bold text-primary">Lista de usuarios</h6>
                    <a href="{{route('profile.create')}}" type="button" class="btn btn-success" title="add" method="GET" data-toggle="tooltip"><i class="fa fa-add mr-1"></i>Agregar</a>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover text-center" id="myTable">    
                            <thead>
                                <tr>
                                    <th scope="col" class="col-lg-2">Nombre y apellido</th>
                                    <th scope="col" class="col-lg-1">Telefono</th>
                                    <th scope="col" class="col-lg-1">Suscripcion</th>
                                    <th scope="col" class="col-lg-1">Acciones</th>
                                    <th scope="col" class="col-lg-1">Cambiar suscripcion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->getFullNameAttribute() }}</td>
                                        <td>{{ $user->primary_phone }}</td>
                                        @if($user->lastSubscription()->first() != null)
                                            <td>{{ $user->lastSubscription()->first()->name}}</td>
                                        @else
                                            <td>{{ __('No tiene') }}</td>
                                        @endif
                                        <td class="text-center d-flex justify-content-center">
                                            <a href="{{ route('profile.edit', ['profile_id' => $user->id]) }}" type="button" class="btn btn-primary mx-1"><i class="fa fa-pencil"></i></a>
                                            <!-- <a href="{{route('profile.edit', ['profile_id' => $user->id])}}" type="button" class="btn btn-secondary mx-1" title="Edit" data-toggle="tooltip"><i class="fa fa-pencil"></i></a> -->
                                            <div>
                                                <form action="{{ route('profile.destroy', ['profile_id' => $user->id]) }}" method="POST" >
                                                    @csrf
                                                    @method("DELETE")
                                                    <button class="btn btn-danger" onclick="return confirm('¿Desea borrar al usuario {{$user->name}}?')" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </div>  
                                        </td>  
                                        <td>
                                            @if($user->lastSubscription()->first() != null)
                                                <form action="{{ route('profile.updateSubscription', ['profile_id' => $user->id]) }}" method="GET" >
                                                    <select class="custom-select" style="text-align:center;" onChange="this.form.submit()" name="newSubscription_id" value="">                                           
                                                    @foreach($subscriptions as $subscription)    
                                                        <option value="{{ $subscription->id }}"  {{($user->lastSubscription()->first()->id === $subscription->id) ? 'Selected' : ''}}>{{ $subscription->name }}</option>
                                                    @endforeach
                                                    </select>
                                                </form>       
                                            @endif
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