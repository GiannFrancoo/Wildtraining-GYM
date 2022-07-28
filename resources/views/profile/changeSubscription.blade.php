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
                                <option selected>Seleccione el usuario</option>                                  
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

    @if($userSubscription != null)
        <form action="{{ route('profile.changeSubscriptionStore', ['profile_id' => $userSubscription->user->id]) }}" method="POST">
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
                            <option selected>Suscripcion</option>                                 
                                @foreach($subscriptions as $subscription)
                                    <option value="{{ $subscription->id }}" >{{ $subscription->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-control-label">{{ _('Suscripcion actual') }}</label>
                            <input type="text" class="form-control" readonly value="{{ $userSubscription->subscription->name }}">
                        </div>       
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-disk mr-1"></i>Guardar cambios</button>
                    </div>
                </div>
            </div>
        </form>
    @endif

    
    
    
    

@endsection