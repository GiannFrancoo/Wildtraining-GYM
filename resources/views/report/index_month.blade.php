@extends('layouts.admin')
@section('main-content')

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
    
    
    <form action="{{ route('report.showMonth') }}" method="GET">
    @csrf
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="font-weight-bold text-danger">{{ __('Indique el intervalo de fecha') }}</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <label class="form-control-label" for="month">{{ __('Seleccione el mes') }}<span class="small text-danger">*</span></label>
                        <select class="custom-select" name="month">
                            @foreach(range(1,12) as $month)
                                <option value="{{$month}}">
                                    {{date("M", strtotime('2016-'.$month))}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-control-label" for="year">{{ __('Seleccione el año') }}<span class="small text-danger">*</span></label>
                        <select class="custom-select" name="year">
                            @for ($year = date('Y'); $year > date('Y') - 100; $year--)
                                <option value="{{$year}}">{{$year}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" name="btnSearch" class="btn btn-dark"><i class="fa fa-search mr-1"></i>Buscar</button>
            </div>
        </div>
    </form>

    
@endsection