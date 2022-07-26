@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Perfil') }}</h1>

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
        <div class="row">
            <div class="col-lg-4 order-lg-2">
                <div class="card shadow mb-4">
                    <div class="card-header text-center mt-3">
                        <h6 class="m-0 font-weight-bold text-primary"> {{ __('Suscripcion') }} </h6>
                    </div>
                    <div class="card-body">
                        <div class="col-lg-12">
                            <select class="custom-select" required name="subscriptionIdSelected" value="old('subscriptionIdSelected')">
                                <option disabled selected>Subscripciones</option>                                          
                                @foreach($subscriptions as $subscription)
                                    <option value="{{$subscription->id}}">{{$subscription->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="col-lg-8 order-lg-1">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Crear cuenta</h6>
                    </div>
                    <div class="card header">
                        <div class="card-body row">
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="name">Nombre<span class="small text-danger">*</span></label>
                                    <input type="text" id="name" required class="form-control" name="name" placeholder="Nombre..." value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="last_name">Apellido(s)<span class="small text-danger">*</span></label>
                                    <input type="text" id="last_name" required class="form-control" name="last_name" placeholder="Apellido(s)..." value="{{ old('last_name') }}">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="email">Email<span class="small text-danger">*</span></label>
                                    <input type="email" id="email" required class="form-control" name="email" placeholder="example@example.com" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="new_password">Celular<span class="small text-danger">*</span></label>
                                    <input type="text" id="new_password" required placeholder="2915678987" class="form-control" name="primary_phone" value="{{ old('primary_phone')}}">
                                    <small id="passwordHelpBlock" class="form-text text-muted">
                                        El celular debe tener un minimo de 9 caracteres
                                    </small>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="new_password">Celular secundario</label>
                                    <input type="text" id="new_password" class="form-control" placeholder="2915678987" name="secundary_phone" value="{{old('secundary_phone')}}">
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="address">Direccion</label>
                                    <input type="text" id="address" class="form-control" placeholder="La Madrid 500" name="address" value="{{old('address')}}">
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group focused"><!-- AGREGAR VALIDACION con fecha minima y maxima-->
                                    <label class="form-control-label" for="birthday">Fecha de nacimiento</label>
                                    <input type="date" max="2022-07-18" id="birthday" class="form-control" name="birthday" value="">
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group focused"><!-- AGREGAR VALIDACION con min="2017-07-18" y max-->
                                    <label class="form-control-label" for="start_date">Fecha de inicio en el gimnasio<span class="small text-danger">*</span></label>
                                    <input type="date" id="new_password" required class="form-control" name="start_date" value="{{ old('start_date') }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="social_work_id">Obra social</label>
                                    <select class="custom-select" required name="social_work_id" value="{{ old('social_work_id') }}">                                 
                                        @foreach($social_works as $social_work)
                                            <option value="{{$social_work->id}}" {{($social_work->name === 'NO POSEE') ? 'Selected' : ''}}>{{$social_work->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="personal_information">Informacion personal</label>
                                    <textarea rows="4" id="new_password" class="form-control" name="personal_information" placeholder="Información que considere importante mencionar... (operaciones, lesiones, etc)" value="{{ old('personal_information') }}">{{ old('personal_information') }}</textarea>
                                </div>
                            </div>
                        </div>       

                        <div class="card footer ">
                            <div class="text-center mb-4 mt-3">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-disk mr-1"></i>Crear usuario</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
