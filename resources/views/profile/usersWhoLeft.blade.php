@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Usuarios que dejaron') }} </h1>

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
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" id="ganancia">{{ __('Total') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $usersLeft->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
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
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Lista de usuarios') }}</h6>
                    <small class="sm text-muted">(Donde su ultima asistencia fue hace más de 30 dias)</small>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover text-center" id="myTable">    
                            <thead>
                                <tr>
                                    <th scope="col">Nombre y apellido</th>
                                    <th scope="col">Telefono</th>
                                    <th scope="col">Suscripcion</th>
                                    <th scope="col">Ultima asistencia</th>
                                    <th scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usersLeft as $user)
                                    <tr>
                                        <td>{{ $user->getFullNameAttribute() }}</td>
                                        <td>{{ $user->primary_phone }}</td>
                                        @if($user->lastSubscription()->first() != null)
                                            <td>{{ $user->lastSubscription()->first()->name}}</td>
                                        @else
                                            <td>{{ __('No tiene') }}</td>
                                        @endif                                         
                                        <td>{{ $user->assistances->first->get()->date->format('m/d/Y') }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('profile.edit', ['profile_id' => $user->id]) }}" type="button" class="btn btn-primary mx-1"><i class="fa fa-pencil"></i></a> 
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