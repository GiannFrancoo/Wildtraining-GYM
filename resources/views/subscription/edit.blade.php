@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Subscripcion: {{ $subscription->name }}</h1>

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
            <h6 class="m-0 font-weight-bold text-primary">Editar subscripción</h6>
        </div>
        <div class="card-body">
            
            <h6 class="heading-small text-muted mb-4">Informacion</h6>
            
            <form method="POST" action="{{ route('subscription.update', ['subscription_id' => $subscription->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                <div class="row">

                    <div class="col-lg-6">
                        <div class="form-group focused">
                            <label class="form-control-label" for="name">Nombre: <span class="small text-danger">*</span></label>
                            <input
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                name="name"
                                value="{{old('name') ?? $subscription->name }}"
                                required autocomplete="off" autofocus
                            >
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group focused">
                            <label class="form-control-label" for="times_a_week">Veces por semana: <span class="small text-danger">*</span></label>
                            <input
                                type="number"
                                class="form-control @error('times_a_week') is-invalid @enderror"
                                name="times_a_week"
                                value="{{old('times_a_week') ?? $subscription->times_a_week }}"
                                required autocomplete="off" autofocus
                            >
                            @error('times_a_week')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="form-group focused">
                            <label class="form-control-label" for="month_price">Precio mensual: <span class="small text-danger">*</span></label>
                            <input
                                type="number"
                                class="form-control @error('month_price') is-invalid @enderror"
                                name="month_price"
                                value="{{old('month_price') ?? $subscription->month_price }}"
                                required autocomplete="off" autofocus
                            >
                            @error('month_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                            
                    <div class="form-group">
                        <button class="btn btn-primary"><i class="fa fa-pencil mr-1"></i>Actualizar</button>
                    </div>

                </div>
            </form>            
        </div>
    </div>


@endsection
