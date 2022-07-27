@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Perfil') }}</h1>

    <!-- User information -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group focused">
                                <label class="form-control-label" for="name">Nombre<span class="small text-danger">*</span></label>
                                <input type="text" id="name" readonly class="form-control" name="name" placeholder="Name" value="{{ old('name', $user->name) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group focused">
                                <label class="form-control-label" for="last_name">Apellido(s)<span class="small text-danger">*</span></label>
                                <input type="text" id="last_name" readonly class="form-control" name="last_name" placeholder="Last name" value="{{ old('last_name', $user->last_name) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="email">Email<span class="small text-danger">*</span></label>
                                <input type="email" id="email" readonly class="form-control" name="email" placeholder="example@example.com" value="{{ old('email', $user->email) }}">
                            </div>
                        </div>

                        <div class="col-md-6">                           
                            <div class="form-group">
                                <label class="form-control-label" for="social_work_id">Rol</label>
                                <input type="email" id="role_id" readonly class="form-control" name="role_id" value="{{ old('role', $user->role->name) }}">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group focused">
                                <label class="form-control-label" for="new_password">Celular<span class="small text-danger">*</span></label>
                                <input type="text" id="new_password" readonly class="form-control" name="primary_phone" value="{{ old('primary_phone', $user->primary_phone) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group focused">
                                <label class="form-control-label" for="new_password">Celular secundario</label>
                                @if($user->secundary_phone === NULL)
                                    <input type="text" id="new_password" readonly class="form-control" name="secundary_phone" value = "-">
                                @else
                                    <input type="text" id="new_password" readonly class="form-control" name="secundary_phone" value="{{ old('secundary_phone', $user->secundary_phone) }}">
                                @endif
                            </div>
                        </div>                        
                        
                        <div class="col-md-6">
                            <div class="form-group focused">
                                <label class="form-control-label" for="address">Direccion</label>
                                <input type="text" id="address" readonly class="form-control" name="address" value="{{ old('address', $user->address) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group focused"><!-- AGREGAR VALIDACION con fecha minima y maxima-->
                                <label class="form-control-label" for="birthday">Fecha de nacimiento</label>
                                @if($user->birthday != NULL)
                                    <input type="date" readonly max="2022-07-18" id="birthday" class="form-control" name="birthday" value="{{ old('birthday', $user->birthday->format('Y-m-d')) }}">
                                @else
                                    <input type="text"readonly max="2022-07-18" id="birthday" placeholder="-" class="form-control" name="birthday" value="">
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group focused"><!-- AGREGAR VALIDACION con min="2017-07-18" y max-->
                                <label class="form-control-label" for="start_date">Fecha de inicio<span class="small text-danger">*</span></label>
                                <input type="date" readonly id="new_password" class="form-control" name="start_date" value="{{ old('start_date', $user->start_date->format('Y-m-d')) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group focused">
                                <label class="form-control-label" for="social_work_id">Obra social</label>
                                <input type="text" readonly id="social_work_id" class="form-control" name="social_work_id" value="{{ old('social_work_id', $user->social_work->name) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group focused">
                                <label class="form-control-label" for="new_password">Subscripcion</label>
                                <input type="text" readonly id="subscription_id" class="form-control" value="{{ $user->lastSubscription()->first()->name }}">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group focused">
                                <label class="form-control-label" for="personal_information">Informacion personal</label>
                                <textarea rows="4" id="personal_information" readonly class="form-control" name="personal_information" value="{{ old('personal_information', $user->personal_information) }}">{{old('personal_information', $user->personal_information)}}</textarea>
                            </div>
                        </div>                     
                                                   
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{route('profile.index')}}" type="submit" class="btn btn-primary">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Subscription historial -->
    <div class="row">
        <div class="col mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Historial de suscripciones de') }}: {{ $user->getFullNameAttribute() }}</h6>
                    <a href="{{ route('profile.create') }}" type="button" class="btn btn-success" title="add" method="GET" data-toggle="tooltip"><i class="fa fa-add mr-1"></i>{{ __('Cambiar suscripción') }}</a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover text-center" id="myTable">    
                        <thead>
                            <tr>
                                <th>Suscripcion</th>
                                <th>Fecha de modificación</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userSubscriptions as $userSubscription)
                                <tr>                               
                                    <td>{{ $userSubscription->subscription->name }}</td>
                                    <td>{{ $userSubscription->user_subscription_status_updated_at->format('d/m/Y') }}</td>
                                    <td>{{ $userSubscription->status->name }}</td>                                
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



@endsection
