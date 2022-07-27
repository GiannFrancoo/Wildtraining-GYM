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

    <form action="{{route('profile.store')}}" method="POST">
    @csrf
        <div class="card shadow mb-4">
            <div class="card-header">                
                <h6 class="heading-small text-muted mb-4"> {{ __('Información') }}</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 form-group focused">
                        <label class="form-control-label">Nombre</label>
                        <!--<form action="{{ route('profile.changeSubscription') }}" method="GET" >-->
                            <select class="custom-select" onChange="this.form.submit()" name="user" value="old('subscriptionIdSelected')">  
                                <option selected value="Usuario">Usuario</option>                                
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        <!--</form> -->
                    </div>
                    <div class="col-lg-6 form-group focused" id="subscriptionUserSelectedId">
                        <label class="form-control-label">Suscripcion</label>
                        <select class="custom-select" name="subscriptionIdSelected" value=""> 
                        <option selected>Suscripcion</option>                                 
                            @foreach($subscriptions as $subscription)
                                <option value="{{$subscription->id}}" >{{$subscription->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-disk mr-1"></i>Guardar cambios</button>
        </div>
    </form>

@endsection
