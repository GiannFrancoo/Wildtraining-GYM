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

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form to edit the user -->
    <form action="{{ route('profile.update', ['profile_id' => $user->id])}}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
        
            <!-- Subscription change -->
            <div class="col-lg-4 order-lg-2">
                <div class="card shadow mb-4">
                    <div class="card-header text-center mt-3">
                        <h6 class="m-0 font-weight-bold text-primary"> {{ __('Suscripcion') }} </h6>
                    </div>
                    <div class="card-body">
                        <div class="col-lg-12">
                            @if($activeSubscription != null)
                                <select  class="custom-select" name="subscriptionIdSelected" value="{{ old('subscriptionIdSelected', $activeSubscription->name) }}">                                          
                                    @foreach($subscriptions as $subscription)
                                        <option value="{{ $subscription->id }}" {{ ($activeSubscription->id === $subscription->id) ? 'Selected' : '' }}>{{ $subscription->name }}</option>
                                    @endforeach
                                </select>
                            @else
                                <select  class="custom-select" name="subscriptionIdSelected" value="old('subscriptionIdSelected')">
                                    <option selected>Subscripciones</option>                                          
                                    @foreach($subscriptions as $subscription)
                                        <option value="{{ $subscription->id }}">{{ $subscription->name }}</option>
                                    @endforeach
                                </select>
                            @endif 
                        </div> 
                    </div>
                </div>
            </div>
            
            <!-- Edit personal information -->
            <div class="col-lg-8 order-lg-1">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('Editando cuenta') }}</h6>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="name">{{ __('Nombre') }}<span class="small text-danger">*</span></label>
                                    <input type="text" id="name" class="form-control" name="name" placeholder="Name" value="{{ old('name', $user->name) }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="last_name">{{ __('Apellidos(s)') }}<span class="small text-danger">*</span></label>
                                    <input type="text" id="last_name" class="form-control" name="last_name" placeholder="Last name" value="{{ old('last_name', $user->last_name) }}">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="email">{{ __('Email') }}<span class="small text-danger">*</span></label>
                                    <input type="email" id="email" class="form-control" name="email" placeholder="ejemplo@ejemplo.com" value="{{ old('email', $user->email) }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label">{{ __('Celular') }}<span class="small text-danger">*</span></label>
                                    <input type="text" id="primaryPhone" class="form-control" name="primary_phone" value="{{ old('primary_phone', $user->primary_phone) }}">
                                    <small class="form-text text-muted">
                                        El celular debe tener un minimo de 9 caracteres
                                    </small>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="secondaryPhone">{{ __('Celular secundario') }}</label>
                                    @if($user->secundary_phone === "")
                                        <input type="text" id="secondaryPhone" class="form-control" name="secondary_phone" value = "-">
                                    @else
                                        <input type="text" id="secondaryPhone" class="form-control" name="secondary_phone" value="{{ old('secondaryPhone', $user->secundary_phone) }}">
                                    @endif
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
                                        <input type="date" max="{{ now() }}" id="birthday" class="form-control" name="birthday" value="{{ old('birthday', $user->birthday->format('Y-m-d')) }}">
                                    @else
                                        <input type="date" max="{{ now() }}" id="birthday" class="form-control" name="birthday" value="">
                                    @endif                                            
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="startDate">{{ __('Fecha de inicio en el gimnasio') }}</label>
                                    <input type="date" id="startDate" class="form-control" name="start_date" value="{{ old('startDate', $user->start_date->format('Y-m-d')) }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="social_work_id">{{ __('Obra social') }}</label>
                                    <select class="custom-select" name="social_work_id" value="{{ old('social_work_id'), $user->social_work->id }}">                                           
                                        @foreach($socialWorks as $socialWork)
                                            <option value="{{ $socialWork->id }}" {{ ($user->social_work->id === $socialWork->id) ? 'Selected' : '' }}>{{ $socialWork->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="personalInformation">{{ __('Informacion personal') }}</label>
                                    <textarea rows="4" id="personalInformation" class="form-control" name="personal_information" value="{{old('personalInformation', $user->personal_information)}}">{{old('personal_information', $user->personal_information)}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-disk mr-1"></i>Guardar cambios</button>
                    </div>       
                </div>
            </div>
        </div>
    </form>

     <!-- Subscription historial -->
     <div class="row">
        <div class="col mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Historial de suscripciones de') }}: {{ $user->getFullNameAttribute() }}</h6>
                    <a href="{{ route('profile.changeSubscription', ['user_id' => $user->id]) }}" type="button" class="btn btn-success" title="add" method="GET" data-toggle="tooltip"><i class="fa fa-add mr-1"></i>{{ __('Cambiar suscripción') }}</a>
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
                                @if ($userSubscription->subscription->name != "NO POSEE")
                                    <tr>                               
                                        <td>{{ $userSubscription->subscription->name }}</td>
                                        <td>{{ $userSubscription->user_subscription_status_updated_at->format('d/m/Y') }}</td>
                                        <td>{{ $userSubscription->status->name }}</td>                                
                                    </tr>
                                @endif
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
        $('table').DataTable()
    })
</script>
@endsection