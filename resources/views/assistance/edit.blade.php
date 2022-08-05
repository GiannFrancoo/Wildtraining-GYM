@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Asistencia') }}: {{ $assistance->user->getFullNameAttribute() }}</h1>

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
    
    <form method="POST" action="{{ route('assistance.update', ['assistance_id' => $assistance->id]) }}">
    @csrf
    @method('PUT')
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-danger">Editando asistencia</h6>
            </div>
            <div class="card-body">            
                <div class="row">
                    <div class="col-6">                        
                        <div class="form-group focused">
                            <label class="form-control-label" for="user">Usuario</label>
                            <select required class="custom-select" id="select2" name="user_id" value="{{ $assistance->user->getFullNameAttribute() }}">                                         
                                @foreach ($users as $user)
                                    <option required value="{{ $user->id }}" {{($user->getFullNameAttribute() === $assistance->user->getFullNameAttribute()) ? 'Selected' : ''}}>
                                        {{ $user->getFullNameAttribute() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group focused">
                            <label class="form-control-label" for="date">Fecha</label>
                            <input type="datetime-local" id="date" class="form-control" placeholder="{{ date('d-m-Y H:i:s') }}" name="date" value="{{ old('date', $assistance->date->format('Y-m-d H:i:s')) }}">
                        </div>
                    </div>
                </div>
            </div>               
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-dark"><i class="fa fa-pencil mr-1"></i>Actualizar</button>
            </div>  
        </div>
    </form>            
    

@endsection

@section('custom_js')
<script>
    $(document).ready(function () {
        $('#select2').select2({
            lenguage: 'es',
            theme: 'bootstrap4',
            width: '100%',
        });
    }); 
</script>
@endsection