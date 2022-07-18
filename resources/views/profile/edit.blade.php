@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Profile') }}</h1>

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
                                <p>{{$user->role->name}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-8 order-lg-1">

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">My Account</h6>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('profile.update') }}" autocomplete="off">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <input type="hidden" name="_method" value="PUT">

                        <h6 class="heading-small text-muted mb-4">Informacion</h6>

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="name">Nombre<span class="small text-danger">*</span></label>
                                        <input type="text" id="name" class="form-control" name="name" placeholder="Name" value="{{ old('name', $user->name) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="last_name">Apellido(s)</label>
                                        <input type="text" id="last_name" class="form-control" name="last_name" placeholder="Last name" value="{{ old('last_name', $user->last_name) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">Email<span class="small text-danger">*</span></label>
                                        <input type="email" id="email" class="form-control" name="email" placeholder="example@example.com" value="{{ old('email', $user->email) }}">
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="new_password">Celular</label>
                                    <input type="text" id="new_password" class="form-control" name="new_password" value="{{ old('primary_phone', $user->primary_phone)}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="new_password">Celular secundario</label>
                                    @if($user->secundary_phone === "")
                                        <input type="text" id="new_password" class="form-control" name="new_password" value = "-">
                                    @else
                                        <input type="text" id="new_password" class="form-control" name="new_password" value="{{old('secundary_phone', $user->secundary_phone)}}">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="new_password">Direccion</label>
                                        <input type="text" id="new_password" class="form-control" name="new_password" value="{{old('address', $user->address)}}">
                                    </div>
                            </div>
                            <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="new_password">Fecha de nacimiento</label>
                                        <input type="date" id="new_password" class="form-control" name="new_password" value="{{old('birthday', $user->birthday->format('d/m/Y'))}}">
                                    </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="new_password">Fecha de inicio</label>
                                        <input type="text" id="new_password" class="form-control" name="new_password">
                                    </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                <label class="form-control-label" for="new_password">Obra social</label>
                                <div class="col-sm-10">
                                    <select class="custom-select" name="social_work" value="{{old('social_work', $user->social_work)}}">
                                        <option disabled selected> {{old('social_work', $user->social_work)}}</option>
                                            @if($user->social_work === 'IOMA')
                                                <option value="PAMI" name="">PAMI</option>
                                                <option value="OSECAC" name="">OSECAC</option>
                                            @elseif($user->social_work === 'OSECAC')
                                                <option value="PAMI" name="">PAMI</option>
                                                <option value="IOMA" name="">IOMA</option>
                                            @else
                                                <option value="OSECAC" name="">OSECAC</option>
                                                <option value="IOMA" name="">IOMA</option>
                                            @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                        <div class="form-group focused">
                            <label class="form-control-label" for="new_password">Informacion personal</label>
                            <input type="text" id="new_password" class="form-control" name="new_password">
                        </div>

                    </div>


                        <!-- Button -->
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection
