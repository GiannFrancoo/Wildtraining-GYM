@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Perfil') }}</h1>

    <div class="row">
            <div class="col-lg-4 order-lg-2">
                <div class="card shadow mb-4">
                    <div class="card-profile-image mt-4">
                        <figure class="rounded-circle avatar avatar font-weight-bold" style="font-size: 60px; height: 180px; width: 180px;" data-initial="{{ Auth::user()->name[0] }}"></figure>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="text-center">
                                    <h5 class="font-weight-bold">{{  $user->getFullNameAttribute() }}</h5>
                                    <div class="text-center">
                                        @if($user->birthday != NULL)
                                        {{$user->role->name}} 
                                            @if($age != 0)
                                                - {{$age}} Años
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 order-lg-1">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Cuenta</h6>
                    </div>

                    <div class="card-body">
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="name">Nombre<span class="small text-danger">*</span></label>
                                            <input type="text" id="name" readonly class="form-control" name="name" placeholder="Name" value="{{ old('name', $user->name) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="last_name">Apellido(s)<span class="small text-danger">*</span></label>
                                            <input type="text" id="last_name" readonly class="form-control" name="last_name" placeholder="Last name" value="{{ old('last_name', $user->last_name) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="email">Email<span class="small text-danger">*</span></label>
                                            <input type="email" id="email" readonly class="form-control" name="email" placeholder="example@example.com" value="{{ old('email', $user->email) }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 -sm-10 mb-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="social_work_id">Rol</label>
                                        <input type="email" id="role_id" readonly class="form-control" name="role_id" value="{{ old('role', $user->role->name) }}">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="new_password">Celular<span class="small text-danger">*</span></label>
                                        <input type="text" id="new_password" readonly class="form-control" name="primary_phone" value="{{ old('primary_phone', $user->primary_phone)}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="new_password">Celular secundario</label>
                                        @if($user->secundary_phone === NULL)
                                            <input type="text" id="new_password" readonly class="form-control" name="secundary_phone" value = "-">
                                        @else
                                            <input type="text" id="new_password" readonly class="form-control" name="secundary_phone" value="{{old('secundary_phone', $user->secundary_phone)}}">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="address">Direccion</label>
                                            <input type="text" id="address" readonly class="form-control" name="address" value="{{old('address', $user->address)}}">
                                        </div>
                                </div>
                                <div class="col-lg-6">
                                        <div class="form-group focused"><!-- AGREGAR VALIDACION con fecha minima y maxima-->
                                            <label class="form-control-label" for="birthday">Fecha de nacimiento</label>
                                            @if($user->birthday != NULL)
                                                <input type="date" readonly max="2022-07-18" id="birthday" class="form-control" name="birthday" value="{{old('birthday', $user->birthday->format('Y-m-d'))}}">
                                            @else
                                                <input type="text"readonly max="2022-07-18" id="birthday" placeholder="-" class="form-control" name="birthday" value="">
                                            @endif
                                        </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                        <div class="form-group focused"><!-- AGREGAR VALIDACION con min="2017-07-18" y max-->
                                            <label class="form-control-label" for="start_date">Fecha de inicio<span class="small text-danger">*</span></label>
                                            <input type="date" readonly id="new_password" class="form-control" name="start_date" value="{{old('start_date', $user->start_date->format('Y-m-d'))}}">
                                        </div>
                                </div>
                                <div class="col-lg-6 -sm-10 mb-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="social_work_id">Obra social</label>
                                        <input type="text" readonly id="social_work_id" class="form-control" name="social_work_id" value="{{old('social_work_id', $user->social_work->name)}}">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-6 -sm-10 mb-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="new_password">Subscripcion</label>
                                        <input type="text" readonly id="subscription_id" class="form-control" value="{{$my_subscription}}">
                                </div>
                            </div>


                            <div class="col-lg-12 form-group focused">
                                <label class="form-control-label" for="personal_information">Informacion personal</label>
                                <textarea rows="4" id="personal_information" readonly class="form-control" name="personal_information" value="{{old('personal_information', $user->personal_information)}}">{{old('personal_information', $user->personal_information)}}</textarea>
                            </div>
                        </div>
                            <!-- Button -->
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col text-center">
                                        <a href="{{route('profile.index')}}" type="submit" class="btn btn-primary">Volver</a>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
