@extends('layouts.admin')

@section('main-content')

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800">{{ __('Generar nuevo pago') }}</h1>

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
 
  <form action="{{ route('payment.create') }}" method="GET">
  @csrf
      <div class="card shadow mb-4">              
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-danger">{{ __('Nombre') }} </h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col form-group focused">
              <select class="custom-select" name="user">
                <option selected value="withoutUser">{{ __('Seleccione un usuario') }}</option>                                  
                @foreach($users as $user)
                  @if($userSelected != null)
                    <option value="{{ $user->id }}" {{ ($userSelected->id === $user->id) ? 'Selected' : ''}}>{{ $user->getFullNameAttribute() }}</option>
                  @else
                    <option value="{{ $user->id }}">{{ $user->getFullNameAttribute() }}</option>
                  @endif
                @endforeach
              </select>
            </div>
          </div>
        </div>
       
        <div class="card-footer text-center align-items-center" onChange="this.form.submit()">
          <button type="submit" class="btn btn-dark"><i class="fa fa-search mr-1"></i>Buscar</button>
        </div>
      </div>
  </form>
 
    @if($userSelected != null)
    <hr>
    <form action="{{ route('payment.store', ['profile_id' => $userSelected->id]) }}" method="POST">
    @csrf
      <div class="row">
        <div class="card shadow col-lg-9 md-4 mb-3">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-danger">{{ __('Generar pago') }} </h6>
          </div>
          <div class="card-body">          
            <div class="row">
              <div class="col-6">
                <div class="form-group focused">
                  <label class="form-control-label" for="name">{{ __('Abonado') }}<span class="small text-danger">*</span></label>       
                  <!--Input precio-->
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">$</span>
                    </div>

                    @if($amounthMonthPay === 1)
                      <input type="number" required class="form-control" min="1" name="price" value="{{ $subscription->month_price }}">
                    @else
                      <input type="number" required class="form-control" min="1" name="price" value="{{ $priceAmounthMonthPay }}">
                    @endif
                  </div>
                  @error('price')
                    <div class="alert alert-danger border-left-danger" role="alert">
                      <ul class="pl-4 my-2">
                          <li>{{$message}}</li>
                      </ul>
                    </div> 
                  @enderror
                </div>     
              </div>

              <div class="col-6">
                <div class="form-group focused">
                    <label class="form-control-label" for="payment">{{ __('Fecha') }}<span class="small text-danger">*</span></label>
                    <input type="datetime-local" id="payment" required class="form-control" name="date" placeholder="payment" value="{{ now() }}">
                    @error('date')
                      <div class="alert alert-danger border-left-danger" role="alert">
                        <ul class="pl-4 my-2">
                            <li>{{$message}}</li>
                        </ul>
                      </div> 
                    @enderror
                </div>
              </div>

              <div class="col-6">
                <div class="form-group focused">
                  <label class="form-control-label" for="user_selected">{{ __('Usuario seleccionado') }}</label>
                  <input type="text" name="userSelected" class="form-control" readonly value="{{ $userSelected->getFullNameAttribute() }}">
                </div>
              </div>

              <div class="col-6">
                <div class="form-group">
                  <label class="form-control-label" for="subscription">{{ __('Plan activo') }}</label>
                  <input type="text" class="form-control" readonly value="{{ $subscription->name }}">
                </div>
              </div>

              <div class="col-6">
                <div class="form-group focused">
                    <label class="form-control-label" for="paymentStatus">{{ __('Estado del pago') }}</label>
                    <select class="custom-select" name="paymentStatus" value="{{ old('paymentStatus') }}">                                           
                        @foreach($paymentStatuses as $paymentStatus)
                          <option value="{{ $paymentStatus->id }}">{{ $paymentStatus->name }}</option>
                        @endforeach
                    </select>
                </div>
              </div>
            </div>
          </div>
          
          <div class="card-footer text-center">
            <button type="submit" class="btn btn-dark"><i class="fa fa-floppy-disk mr-1"></i>{{ __('Generar pago') }}</button>
          </div>
        </div>
      
        <div class="col-lg-3 md-2 mb-2">
          <div class="card shadow">
            <div class="card-header text-center align-items-center">
              <h6 class="m-0 font-weight-bold text-danger">Meses a abonar</h6>    
            </div>
            <div class="card-body text-center align-items-center">
              <input type="number" class="form-control text-center" id="onthsPay" min="1" name="amounthMonthPay" value="{{ $amounthMonthPay }}">
            </div>
            <div class="card-footer text-center">
              <button type="submit" class="btn btn-dark" name="btnApply"><i class="fa fa-pencil mr-1"></i>{{ __('Aplicar') }}</button>
            </div>
          </div>
        </div>
      </div>
    </form> 
  @endif

@endsection
