@extends('layouts.admin')
@section('main-content')

    <h1 class="h3 mb-4 text-gray-800">{{ __('Cambiar suscripcion') }}</h1>

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

    
    <form action="{{ route('profile.changeSubscription') }}" method="GET">
    @csrf
        <div class="card shadow mb-4">
            <div class="card-header">                
                <h6 class="heading-small text-muted mb-4"> {{ __('Seleccion de usuario') }}</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 form-group focused">
                        <label class="form-control-label">Nombre</label>
                            <select class="custom-select" onChange="this.form.submit()" name="user">
                                <option selected value="withoutUser">Seleccione el usuario</option>                                  
                                @foreach($users as $user)
                                    @if($userSelected != null)
                                        <option value="{{ $user->id }}" {{ ($userSelected->id === $user->id) ? 'Selected' : ''}}>{{ $user->getFullNameAttribute() }}</option>
                                    @else
                                        <option value="{{ $user->id }}">{{ $user->getFullNameAttribute() }}</option>
                                    @endif
                                @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>   

    @if($userSubscription != null || $userSubscription === 'sinSubscripcion')
        <form action="{{ route('profile.changeSubscriptionStore', ['profile_id' => $userSelected->id]) }}" method="POST">
        @csrf
        @method('PUT')
            <div class="card shadow mb-4"> 
                <div class="card-header">                
                    <h6 class="heading-small text-muted mb-4"> {{ __('Seleccion de suscripcion nueva') }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">                    
                        <div class="col-lg-6 form-group focused" id="subscriptionUserSelectedId">
                            <label class="form-control-label">Suscripcion nueva</label>
                            <select class="custom-select" name="subscriptionIdSelected" value="">  
                                @if($userSubscription != 'sinSubscripcion')                                
                                    @foreach($subscriptions as $subscription)
                                        <option value="{{ $subscription->id }}" {{ ($userSubscription->subscription->id === $subscription->id) ? 'Selected' : ''}} >{{ $subscription->name }}</option>
                                    @endforeach
                                    <option value="sinSubscripcion">Sin suscripcion</option>
                                @else
                                    <option selected value="sinSubscripcion">Sin suscripcion</option>
                                    @foreach($subscriptions as $subscription)
                                        <option value="{{ $subscription->id }}" >{{ $subscription->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-lg-6">
                        <label class="form-control-label">{{ _('Suscripcion actual') }}</label>
                        @if($userSubscription != 'sinSubscripcion')
                            <input type="text" class="form-control" readonly value="{{ $userSubscription->subscription->name }}">
                        @else
                            <input type="text" class="form-control" readonly value="Sin suscripcion">
                        @endif
                        </div>       
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-disk mr-1"></i>Guardar cambios</button>
                    </div>
                </div>
            </div>
        </form>
    @endif

<hr>

    <!-- Subscriptions table -->
    <div class="row">
        <div class="col mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Lista de suscripciones') }}</h6>
                    <a href="{{route('subscription.create')}}" class="btn btn-danger mr-1"><i class="fa fa-add mr-1"></i>{{ __('Crear nueva suscripción') }}</a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover text-center" id="dataTable">    
                        <thead>
                            <tr>
                                <th scope="col">{{ __('Nombre') }}</th>
                                <th scope="col">{{ __('Veces por semana') }}</th>
                                <th scope="col">{{ __('Precio') }}</th>
                                <th scope="col">{{ __('Acciones') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subscriptions as $subscription)
                                <tr>
                                    <td>{{ $subscription->name }}</td>
                                    <td>{{ $subscription->times_a_week }} </td>
                                    <td>$ {{ $subscription->month_price }}</td>
                                    <td>
                                        <a href="{{ route('subscription.show', ['subscription_id' => $subscription->id]) }}" type="button" class="btn btn-secondary" title="Show" data-toggle="tooltip"><i class="fa fa-users mr-1"></i>Ver inscriptos</a>
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