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
              <select class="custom-select" name="user" id="select2">
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
      <div class="row d-flex">
        <div class="col-lg-9 col-md-9 col-sm-12 order-md-1 order-sm-2">
          <div class="card shadow mb-3">
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
                        <input type="number" required class="form-control" id="priceInput" min="1" name="price" value="{{ $subscription->month_price }}">
                      @else
                        <input type="number" required class="form-control" min="1" id="priceInput" name="price" value="{{ $priceAmounthMonthPay }}">
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
                      <label class="form-control-label" for="date">{{ __('Fecha') }}<span class="small text-danger">*</span></label>
                      <input type="datetime-local" id="date" required class="form-control" name="date" placeholder="date" value="{{ now() }}">
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
                      <select class="custom-select" id="statusPayment" name="paymentStatus" value="{{ old('paymentStatus') }}">                                          
                        <option value="{{ $paymentStatusDefault->id }}" selected>{{ $paymentStatusDefault->name }}</option>
                          @foreach($paymentStatuses as $payment)
                            @if($payment->id != $paymentStatusDefault->id)
                              <option value="{{ $payment->id }}" {{( old('paymentStatus') === $payment->id) ? 'Selected' : ''}}>{{ $payment->name }}</option>
                            @endif
                          @endforeach
                      </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer text-center">
              <button type="button" class="btn btn-dark" name="activateModal" data-toggle="modal" data-target="#exampleModalCenter" onClick="getValueInput()" ><i class="fa fa-floppy-disk mr-1"></i>{{ __('Generar pago') }}</button>
            </div>
          </div>
        </div>
      
        <div class="col-lg-3 col-md-3 col-sm-12 order-md-2 order-sm-1">
          <div class="card shadow  mb-3">
            <div class="card-header text-center align-items-center">
              <h6 class="m-0 font-weight-bold text-danger">Meses a abonar</h6>    
            </div>
            <div class="card-body text-center align-items-center">
              <input type="number" class="form-control text-center" id="domTextElement" id="onthsPay" min="1" name="amounthMonthPay" value="{{ $amounthMonthPay }}">
            </div>
            <div class="card-footer text-center">
              <button type="submit" class="btn btn-dark" name="btnApply"><i class="fa fa-forward mr-1"></i>{{ __('Aplicar') }}</button>
              <!-- Modal -->
              <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered "  role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title-center" id="exampleModalLongTitle">Generando pagos</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="card-body table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">Abonado <i class="fa fa-credit-card" aria-hidden="true"></i></th>
                              <td scope="col">Fecha <i class="fa fa-calendar" aria-hidden="true"></i></td>
                              <td scope="col">Usuario <i class="fa fa-user"></i></td>
                              <td scope="col">Plan activo <i class="fa fa-flag" aria-hidden="true"></i></td>
                              <td scope="col">Estado del pago</td>
                              <td scope="col"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <div class="card">
                                <th>$ <p class="d-inline" id="valuePrice"></p></th>
                                <th>{{ now()->format('d/m/Y') }}</th>
                                <th>{{ $userSelected->getFullNameAttribute() }}</th>
                                <th>{{ $subscription->name }}</th>
                                <th><p class="d-inline" id="valueStatus"></p></th>
                                  @if($amounthMonthPay != 1)
                                      <td class="bg-danger text-left"><FONT COLOR="white"><li >Cantidad de pagos a generar: &nbsp; <p id="valueInput" class="d-inline"></p></li>
                                      <li>Los pagos se generaran a partir de este mes ({{ now()->locale('es')->monthName }}) inclusive</li></FONT></td>
                                  @else
                                    <td class="bg-dark"><FONT COLOR="white"><li>Se generara el pago de este mes ({{ now()->locale('es')->monthName }})</li></FONT></td>
                                  @endif
                                </div>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="modal-footer text-left">
                      <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
                      <button type="submit" class="btn btn-success">Confirmar <i class="fa fa-check" aria-hidden="true"></i></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form> 
  @endif
  @endsection

@section('custom_js')
<script>
   function getValueInput (){
      let inputValue = document.getElementById("domTextElement").value; 
        document.getElementById("valueInput").innerHTML = inputValue; 
        
        inputValue = document.getElementById("priceInput").value; 
        document.getElementById("valuePrice").innerHTML = inputValue;
        console.log(inputValue);

        inputValue = document.getElementById("statusPayment").value; 
          document.getElementById("valueStatus").innerHTML = inputValue;
    }

    

    $(document).ready(function () {
      $('#select2').select2({
              lenguage: 'es',
              theme: 'bootstrap4',
              width: '100%',
        });
    });

</script>
@endsection
