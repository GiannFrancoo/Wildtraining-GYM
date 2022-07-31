@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Creando nueva asistencia') }}</h1>

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

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-danger">Nueva asistencia</h6>
        </div>
        <div class="card-body">            
            <form action="{{ route('assistance.store')}}" method="POST">
            @csrf
                <div class="row">

                    <div class="col-6">                        
                        <div class="form-group focused">
                            <label class="form-control-label" for="user">Usuario</label>
                            <select  class="custom-select" required name="user_id" value="{{ old('user_id') }}">                                           
                                @foreach($users as $user)
                                    <option required value="{{ $user->id }}">{{ $user->getFullNameAttribute() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group focused">
                            <label class="form-control-label" for="date">Fecha</label>
                            <input type="datetime-local" id="date" required class="form-control" placeholder="{{ date('d-m-Y H:i:s') }}" name="date" value="{{ now()->format('Y-m-d H:i:s') }}">
                        </div>
                    </div>

                </div>

                <hr class="mt-2">

                <div class="text-center">
                    <button type="submit" class="btn btn-dark"><i class="fa fa-floppy-disk mr-1"></i>{{ __('Marcar asistencia') }}</button>
                </div>

            </form>            
        </div>
    </div>


@endsection