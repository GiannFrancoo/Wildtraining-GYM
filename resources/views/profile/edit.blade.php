@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Perfil') }}</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    <!-- Form to edit the user -->
    <form action="{{ route('profile.update', ['profile_id' => $user->id])}}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
                  
            <!-- Edit personal information -->
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-danger">{{ __('Editando cuenta') }}</h6>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="name">{{ __('Nombre') }}<span class="small text-danger">*</span></label>
                                    <input type="text" id="name" class="form-control" name="name" placeholder="Name" value="{{ old('name', $user->name) }}">
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
                                    <input type="text" id="last_name" class="form-control" name="last_name" placeholder="Last name" value="{{ old('last_name', $user->last_name) }}">
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
                                    <label class="form-control-label" for="gender">{{ __('Sexo') }}<span class="small text-danger">*</span></label>
                                    <select class="custom-select" required id="gender_id" name="gender_id" value="{{ old('gender_id', $user->gender->id) }}">                                 
                                        @foreach($genders as $gender)
                                            <option value="{{ $gender->id }}" {{ old('gender_id', $user->gender->id) == $gender->id ? 'Selected' : '' }}>{{ $gender->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="email">{{ __('Email') }}</label>
                                    <input type="email" id="email" class="form-control" name="email" placeholder="ejemplo@ejemplo.com" value="{{ old('email', $user->email) }}">
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
                                    <label class="form-control-label">{{ __('Celular') }}</label>
                                    <input type="text" id="primaryPhone" pattern=".{9,}" placeholder="2915678987" title="Tiene que ingresar como minimo 9 caracteres" class="form-control" name="primary_phone" value="{{ old('primary_phone', $user->primary_phone) }}">
                                    <small class="form-text text-muted">
                                        El celular debe tener un minimo de 9 caracteres
                                    </small>
                                    @error('primary_phone')
                                        @if($message === "El campo primary phone debe ser un número.")
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

                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="secondaryPhone">{{ __('Celular secundario') }}</label>
                                    @if($user->secondary_phone === "")
                                        <input type="text" id="secondaryPhone" pattern=".{9,}" placeholder="2915678987" title="Tiene que ingresar como minimo 9 caracteres" class="form-control" name="secondary_phone" value = "-">
                                    @else
                                        <input type="text" id="secondaryPhone" pattern=".{9,}" placeholder="2915678987" title="Tiene que ingresar como minimo 9 caracteres" class="form-control" name="secondary_phone" value="{{ old('secondary_phone', $user->secondary_phone) }}">
                                    @endif

                                    @error('secondary_phone')
                                        @if($message === "El campo secondary phone debe ser un número.")
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
                                    <input type="text" id="address" class="form-control" placeholder="La Madrid 500" name="address" value="{{ old('address', $user->address) }}">
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="birthday">{{ __('Fecha de nacimiento') }}</label>
                                    @if($user->birthday != NULL)
                                        <input type="date" id="birthday" class="form-control" name="birthday" value="{{ old('birthday', $user->birthday->format('Y-m-d')) }}">
                                    @else
                                        <input type="date" id="birthday" class="form-control" name="birthday" value="{{ old('birthday') }}">
                                    @endif 
                                    
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
                                    <label class="form-control-label" for="startDate">{{ __('Fecha de inicio en el gimnasio') }}<span class="small text-danger">*</span></label>
                                    <input type="date" id="startDate" class="form-control" name="start_date" value="{{ old('start_date', $user->start_date->format('Y-m-d')) }}">
                                </div>
                            </div>

                            @if($user->social_work_id != null)
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="social_work_id">{{ __('Obra social') }}</label>
                                        <select class="custom-select" id="social_work_id" name="social_work_id" value="{{ old('social_work_id'), $user->social_work_id }}">                                           
                                            @foreach($socialWorks as $socialWork)
                                                <option value="{{ $socialWork->id }}" {{ old('social_work_id', $user->social_work_id) == $socialWork->id ? 'Selected' : '' }}>{{ $socialWork->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @else
                            <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="social_work_id">{{ __('Obra social') }}</label>
                                        <select class="custom-select" id="social_work_id" name="social_work_id" value="{{ old('social_work_id'), $user->social_work_id }}">                                           
                                            @foreach($socialWorks as $socialWork)
                                                <option value="{{ $socialWork->id }}" {{ old('social_work_id') == $socialWork->id ? 'Selected' : '' }}>{{ $socialWork->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif  

                            <div class="col-md-12">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="personalInformation">{{ __('Informacion personal') }}</label>
                                    <textarea rows="4" id="personalInformation" class="form-control" name="personal_information" placeholder="Información que considere importante mencionar... (operaciones, lesiones, etc)" value="{{old('personalInformation', $user->personal_information)}}">{{old('personal_information', $user->personal_information)}}</textarea>
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

             <!-- Subscription change -->
             <div class="col-12">
                <div class="card shadow mb-2">
                    <div class="card-header text-center mt-3">
                        <h6 class="m-0 font-weight-bold text-danger"> {{ __('Plan') }} </h6>
                    </div>
                    <div class="card-body">
                        <div class="col-lg-12">
                            @if($activeSubscription != null)
                                <select  class="custom-select" name="subscriptionIdSelected" value="{{ old('subscriptionIdSelected', $user->lastSubscription->first()->id) }}">                                          
                                    @if( old('subscriptionIdSelected') === 'sinSubscripcion')
                                        <option value="sinSubscripcion">Sin plan</option>
                                        @foreach($subscriptions as $subscription)  
                                            <option value="{{ $subscription->id }}">{{ $subscription->name }}</option>
                                        @endforeach
                                    @else
                                        @foreach($subscriptions as $subscription)  
                                            <option value="{{ $subscription->id }}" {{ old('subscriptionIdSelected', $user->lastSubscription->first()->id) == $subscription->id ? 'Selected' : '' }}>{{ $subscription->name }}</option>
                                        @endforeach
                                    @endif
                                    <option value="sinSubscripcion">Sin plan</option>                                          
                                </select>
                            @else
                                <select  class="custom-select" name="subscriptionIdSelected" value="{{ old('subscriptionIdSelected') }}">
                                    <option selected value="sinSubscripcion">Sin plan</option>                                          
                                    @foreach($subscriptions as $subscription)
                                        <option value="{{ $subscription->id }}" {{ old('subscriptionIdSelected') ==  $subscription->id ? 'Selected' : ''}}>{{ $subscription->name }}</option>
                                    @endforeach
                                </select>
                            @endif 
                        </div> 
                    </div>               
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-dark"><i class="fa fa-floppy-disk mr-1"></i>Actualizar</button>
                    </div> 
                </div>
            </div> 

        </div>
    </form>   
@endsection