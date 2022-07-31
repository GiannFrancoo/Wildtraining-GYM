@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Creando nuevo usuario') }}</h1>
 
    <form action="{{route('profile.store')}}" method="POST">
    @csrf
        <div class="row">
        
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h6 class="font-weight-bold text-danger">{{ __('Información del nuevo usuario') }}</h6>
                    </div>
                    <div class="card header">
                        <div class="card-body row">
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="name">{{ __('Nombre') }}<span class="small text-danger">*</span></label>
                                    <input type="text" id="name" required class="form-control" name="name" placeholder="Nombre..." value="{{ old('name') }}">
                                    @error('name')
                                        <div class="alert alert-danger border-left-danger" role="alert">
                                            <ul class="pl-4 my-2">
                                                <li>{{$message}}</li>
                                            </ul>
                                        </div>                                    
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="last_name">{{ __('Apellidos(s)') }}<span class="small text-danger">*</span></label>
                                    <input type="text" id="last_name" required class="form-control" name="last_name" placeholder="Apellido(s)..." value="{{ old('last_name') }}">
                                    @error('last_name')
                                        <div class="alert alert-danger border-left-danger" role="alert">
                                            <ul class="pl-4 my-2">
                                                <li>{{$message}}</li>
                                            </ul>
                                        </div>                                    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="gender_id">{{ __('Sexo') }}<span class="small text-danger">*</span></label>
                                    <select class="custom-select" required id="gender_id" name="gender_id" value="{{ old('gender_id, $gender->id') }}">                                 
                                        @foreach($genders as $gender)
                                            <option value="{{ $gender->id }}" {{old('gender_id') == $gender->id ? "selected" : ""}}>{{ $gender->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="email">{{ __('Email') }}<span class="small text-danger">*</span></label>
                                    <input type="email" id="email" required class="form-control" name="email" placeholder="example@example.com" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="alert alert-danger border-left-danger" role="alert">
                                            <ul class="pl-4 my-2">
                                                <li>{{$message}}</li>
                                            </ul>
                                        </div>                                    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="new_password">{{ __('Celular') }}<span class="small text-danger">*</span></label>
                                    <input type="numeric" id="new_password" required pattern=".{9,}" title="Tiene que ingresar como minimo 9 caracteres" placeholder="2915678987" class="form-control" name="primary_phone" value="{{ old('primary_phone')}}">
                                    <small id="passwordHelpBlock" class="form-text text-muted">
                                        El celular debe tener un minimo de 9 caracteres
                                    </small>
                                    @error('primary_phone')
                                        @if($message === "El valor del campo primary phone ya está en uso.")
                                            <div class="alert alert-danger border-left-danger" role="alert">
                                                <ul class="pl-4 my-2">
                                                    <li>{{ __('El celular ingresado ya esta en uso.') }}</li>
                                                </ul>
                                            </div> 
                                        @else
                                            <div class="alert alert-danger border-left-danger" role="alert">
                                                <ul class="pl-4 my-2">
                                                    <li>{{ __('El celular ingresado debe ser solo numeros.') }}</li>
                                                </ul>
                                            </div> 
                                        @endif
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="new_password">{{ __('Celular secundario') }}</label>
                                    <input type="text" id="new_password" pattern=".{9,}" title="Tiene que ingresar como minimo 9 caracteres" class="form-control" placeholder="2915678987" name="secondary_phone" value="{{ old('secondary_phone') }}">
                                    @error('secondary_phone')
                                        @if($message === "El valor del campo secondary phone ya está en uso.")
                                            <div class="alert alert-danger border-left-danger" role="alert">
                                                <ul class="pl-4 my-2">
                                                    <li>{{ __('El celular ingresado ya esta en uso.') }}</li>
                                                </ul>
                                            </div> 
                                        @elseif($message === "El campo secondary phone debe ser un número.")
                                            <div class="alert alert-danger border-left-danger" role="alert">
                                                <ul class="pl-4 my-2">
                                                    <li>{{ __('El celular ingresado debe ser solo numeros.') }}</li>
                                                </ul>
                                            </div> 
                                        @else
                                            <div class="alert alert-danger border-left-danger" role="alert">
                                                <ul class="pl-4 my-2">
                                                    <li>{{$message}}</li>
                                                </ul>
                                            </div> 
                                        @endif
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="address">{{ __('Direccion') }}</label>
                                    <input type="text" id="address" class="form-control" placeholder="La Madrid 500" name="address" value="{{ old('address') }}">
                                    @error('address')
                                        <div class="alert alert-danger border-left-danger" role="alert">
                                            <ul class="pl-4 my-2">
                                                <li>{{$message}}</li>
                                            </ul>
                                        </div> 
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group focused"><!-- AGREGAR VALIDACION con fecha minima y maxima-->
                                    <label class="form-control-label" for="birthday">{{ __('Fecha de nacimiento') }}</label>
                                    <input type="date"  id="birthday" class="form-control" name="birthday" value="{{ old('birthday') }}">
                                    @error('birthday')
                                        <div class="alert alert-danger border-left-danger" role="alert">
                                            <ul class="pl-4 my-2">
                                                <li>{{$message}}</li>
                                            </ul>
                                        </div> 
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group focused"><!-- AGREGAR VALIDACION con min="2017-07-18" y max-->
                                    <label class="form-control-label" for="start_date">{{ __('Fecha de inicio en el gimnasio') }}<span class="small text-danger">*</span></label>
                                    <input type="date" id="new_password" required class="form-control"  name="start_date" value="{{ old('start_date', now()->format('Y-m-d')) }}">
                                    @error('start_date')
                                        <div class="alert alert-danger border-left-danger" role="alert">
                                            <ul class="pl-4 my-2">
                                                <li>{{$message}}</li>
                                            </ul>
                                        </div> 
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="social_work_id">{{ __('Obra social') }}</label>
                                    <select class="custom-select" required id="social_work_id" name="social_work_id" value="{{ old('social_work_id') }}">                                 
                                        @foreach($social_works as $social_work)
                                            <option value="{{ $social_work->id }}" {{old('social_work_id') == $social_work->id ? "selected" : ""}}>{{ $social_work->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="personal_information">{{ __('Información personal') }}</label>
                                    <textarea rows="4" id="new_password" class="form-control" name="personal_information" placeholder="Información que considere importante mencionar... (operaciones, lesiones, etc)" value="{{ old('personal_information') }}">{{ old('personal_information') }}</textarea>
                                    @error('personal_information')
                                        <div class="alert alert-danger border-left-danger" role="alert">
                                            <ul class="pl-4 my-2">
                                                <li>{{$message}}</li>
                                            </ul>
                                        </div> 
                                    @enderror
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header text-center">
                        <h6 class="m-0 font-weight-bold text-danger"> {{ __('Suscripcion') }} </h6>
                    </div>
                    <div class="card-body">
                        <div class="col-lg-12">
                            <select class="custom-select" required name="subscriptionIdSelected" value="old('subscriptionIdSelected')">
                                <option selected value="sinSubscripcion"> Sin suscripcion </option>                                  
                                @foreach($subscriptions as $subscription)
                                    <option value="{{$subscription->id}}" {{old('subscriptionIdSelected') == $subscription->id ? "selected" : ""}}>{{ $subscription->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>     

                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-dark"><i class="fa fa-floppy-disk mr-1"></i>{{ __('Crear usuario') }}</button>
                    </div>
                </div>
            </div>

        </div>
    </form>
@endsection
