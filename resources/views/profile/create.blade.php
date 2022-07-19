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

    @if(Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
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

    
    <form action="{{ route('profile.store')}}" method="POST" enctype="multipart/form-data">
    @csrf

        <div class="row">

            <div class="col-lg-8 order-lg-1">

                <div class="card shadow mb-4">

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Crear cuenta</h6>
                    </div>

                    <div class="card-body">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">

                            <h6 class="heading-small text-muted mb-4">Informacion</h6>

                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="name">Nombre<span class="small text-danger">*</span></label>
                                            <input type="text" id="name" class="form-control" required name="name" placeholder="Nombre..." value="{{old('name')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="last_name">Apellido(s)<span class="small text-danger">*</span></label>
                                            <input type="text" id="last_name" class="form-control" required name="last_name" placeholder="Apellido(s)..." value="{{old('last_name')}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="email">Email<span class="small text-danger">*</span></label>
                                            <input type="email" id="email" class="form-control" required name="email" placeholder="ejemplo@gmail.com" value="{{old('email')}}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 -sm-10 mb-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="new_password">Rol</label>
                                        <select  class="custom-select" required name="role_id" value="{{old('role_id')}}">                                           
                                            @foreach($roles as $role)
                                                <option required value="{{$role->id}}">{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="new_password">Celular<span class="small text-danger">*</span></label>
                                        <input type="text" id="new_password" class="form-control" required name="primary_phone" placeholder="2915678987" value="{{ old('primary_phone')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="new_password">Celular secundario</label>
                                            <input type="text" id="new_password" class="form-control" name="secundary_phone" value="{{old('secundary_phone')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="address">Direccion</label>
                                            <input type="text" id="address" class="form-control" name="address" placeholder="Lamadrid500" value="{{old('address')}}">
                                        </div>
                                </div>
                                <div class="col-lg-6">
                                        <div class="form-group focused"><!-- AGREGAR VALIDACION con fecha minima y maxima-->
                                            <label class="form-control-label" for="birthday">Fecha de nacimiento</label>
                                            <input type="date" max="2022-07-18" id="birthday" class="form-control" placeholder="1998-07-09" name="birthday" value="{{old('birthday')}}">
                                        </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                        <div class="form-group focused"><!-- AGREGAR VALIDACION con min="2017-07-18" y max-->
                                            <label class="form-control-label" for="start_date">Fecha de inicio</label>
                                            <input type="date" id="new_password" class="form-control" placeholder="2022-07-15" name="start_date" value="{{old('start_date')}}">
                                        </div>
                                </div>
                                <div class="col-lg-6 -sm-10 mb-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="social_work_id">Obra social</label>
                                        <select class="custom-select" name="social_work_id" value="{{old('social_work_id')}}">                                           
                                            @foreach($social_works as $social_work)
                                                <option value="{{$social_work->id}}">{{$social_work->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 -sm-10 mb-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="new_password">Subscripcion</label>
                                        <select  class="custom-select" required name="subscription" value="{{old('subscription')}}">                                           
                                            @foreach($subscriptions as $subscription)
                                                <option required value="{{$subscription->id}}">{{$subscription->name}}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                            
                            
                                <div class="col-lg-12 form-group focused">
                                    <label class="form-control-label" for="personal_information">Informacion personal</label>
                                    <textarea rows="4" id="new_password" class="form-control" name="personal_information" placeholder="....." value="{{old('personal_information')}}"></textarea>
                                </div>

                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" required for="current_password">Contraseña (8 caracteres min)</label>
                                            <input type="password" required id="confirm_password" class="form-control" name="password" placeholder="hola1234" value="{{old('password')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="confirm_password">Confirmar contraseña</label>
                                            <input type="password" required data-toggle="tooltip" data-placement="top" title="8 caracteres minimo" data-tip="8 caracteres minimo" id="confirm_password" class="form-control" name="password_confirmation" placeholder="Confirmar contraseña..." value="{{old('password_confirmation')}}">
                                        </div>
                                    </div>
                            </div>


                            <!-- Button -->
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col text-center">
                                        <button type="submit" class="btn btn-primary">Crear usuario</button>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </form>



@endsection
