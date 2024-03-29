@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Creando nuevo plan') }}</h1>

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

    <form action="{{ route('subscription.store')}}" method="POST">
    @csrf
        <div class="card shadow mb-4">
            <div class="card-body">    
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group focused">
                            <label class="form-control-label" for="name">Nombre<span class="small text-danger">*</span></label>
                            <input type="text" id="name" class="form-control" required name="name" placeholder="Nombre..." value="{{old('name')}}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group focused">
                            <label class="form-control-label" for="last_name">Veces por semana<span class="small text-danger">*</span></label>
                            <input type="number" min="0" id="times_a_week" class="form-control" required name="times_a_week" placeholder="Veces por semana..." value="{{old('times_a_week')}}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-control-label" for="month_price">Precio por mes<span class="small text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="number" step="0.50" id="month_price" class="form-control" required name="month_price" min="0" placeholder="1234" value="{{old('month_price')}}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-center">
                <button type="submit" class="btn btn-dark"><i class="fa fa-floppy-disk mr-1"></i>{{ __('Crear plan') }}</button>
            </div>               

        </div>
    </form>            


@endsection
