@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Suscripción: {{ $subscription->name }}</h1>

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

    <!-- Card with subscriptions -->
    <div class="row">
        <div class="col mb-2">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="font-weight-bold">{{ $subscription->name }}</h5>
                    <div class="row">                        
                        <a href="{{ route('subscription.edit', ['subscription_id' => $subscription->id]) }}" class="btn btn-circle btn-secondary mr-1"><i class="fa fa-pencil"></i></a>
                        <form action="{{ route('subscription.destroy', ['subscription_id' => $subscription->id]) }}" method="POST">
                            @csrf
                            @method("DELETE")
                            <button class="btn btn-danger btn-circle mx-2" type="submit" onclick="return confirm('¿Desea eliminar esta subscripción y con ella todos los alumnos suscriptos?')"><i class="fa fa-trash"></i></button>
                        </form>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td>Veces por semana:</td>
                                <td class="text-right">{{ $subscription->times_a_week }}</td>
                            </tr>
                            <tr>
                                <td>Precio mensual:</td>
                                <td class="text-right">${{ $subscription->month_price }}</td>
                            </tr>
                            <tr>
                                <td>Fecha de modificación:</td>
                                <td class="text-right">{{ $subscription->modification_date->format('d/m/Y') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <hr>

    <!-- Subscriptions table --> 
    <div class="row">
        <div class="col mb-4">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-6 my-2">    
                            <h6 class="m-0 font-weight-bold text-danger">{{ __('Lista de usuarios en la suscripción') }}</h6>
                        </div>
                        <div>
                            <a href="{{ route('profile.create') }}" type="button" class="btn btn-dark float-right" title="Add" data-toggle="tooltip"><i class="fa fa-plus mr-1"></i>Agregar</a>                        
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover text-center" id="dataTable">    
                        <thead>
                            <tr>
                                <th scope="col">{{ __('Usuario') }}</th>
                                <th scope="col">{{ __('Telefono') }}</th>
                                <th scope="col">{{ __('Acciones') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->getFullNameAttribute() }}</td>
                                    <td>{{ $user->primary_phone }}</td>
                                    <td class="d-flex justify-content-center">
                                        <a href="{{ route('profile.show', ['profile_id' => $user->id]) }}" type="button" class="btn btn-circle btn-light mx-2" title="Show" data-toggle="tooltip"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('profile.edit', ['profile_id' => $user->id]) }}" type="button" class="btn btn-circle btn-secondary" title="Edit" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>

                                        <form method="POST" action="{{ route('profile.destroy', ['profile_id' => $user->id]) }}">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-circle btn-danger mx-2" onclick="return confirm('¿Desea borrar este usuario: {{ $user->getFullNameAttribute() }}?')" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></button>
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

