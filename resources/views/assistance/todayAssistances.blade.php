@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Asistencias de hoy: ') }}<small class="text-muted">{{ now()->format('d/m/Y') }}</small></h1>

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

    <!-- Cards -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">{{ __('Asistencias de hoy') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $todayAssistances->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assistances table  -->
    <div class="row">
        <div class="col mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-danger">{{ __('Lista de asistencias de hoy') }}</h6>
                    <a href="{{route('assistance.create')}}" class="btn btn-dark mr-1"><i class="fa fa-add mr-1"></i>{{ __('Nueva') }}</a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover text-center" id="dataTable">    
                        <thead>
                            <tr>
                                <th scope="col">{{ __('Usuario') }}</th>
                                <th scope="col">{{ __('Fecha') }}</th>
                                <th scope="col">{{ __('Hora') }}</th>
                                <th scope="col">{{ __('Acciones') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($todayAssistances as $assistance)
                                <tr>
                                    <td>{{ $assistance->user->getFullNameAttribute() }}</td>
                                    <td data-sort="Ymd">{{ $assistance->date->format('d/m/Y') }}</td>
                                    <td>{{ $assistance->date->format('H:i') }}</td>
                                    <td class="d-flex justify-content-center">
                                        <a href="{{ route('profile.show', ['profile_id' => $assistance->user->id]) }}" type="button" class="btn btn-circle btn-light mx-2" title="Show" data-toggle="tooltip"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('assistance.edit', ['assistance_id' => $assistance->id]) }}" type="button" class="btn btn-circle btn-secondary" title="Edit" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
                                        
                                        <form method="POST" action="{{ route('assistance.destroy', ['assistance_id' => $assistance->id]) }}" class="d-inline">  
                                            @csrf    
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-circle btn-danger ml-2" onclick="return confirm('¿Desea borrar la assistencia de: {{ $assistance->user->getFullNameAttribute() }}?')" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
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
        $('#dataTable').DataTable({
            order: [1, 'desc'],
        })
    })
</script>
@endsection