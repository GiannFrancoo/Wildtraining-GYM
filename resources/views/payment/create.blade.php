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
        <div class="col-lg-12 col-md-9 col-sm-12 order-md-1 order-sm-2">
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
                        <input type="number" required class="form-control" oninput="changePriceValue()" id="priceInput" min="1" name="price" value="{{ $subscription->month_price }}">
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
                <div class="col-3">
                  <div class="form-group focused">
                    <label class="form-control-label" for="paymentStatus">{{ __('Meses a abonar') }}<span class="small text-danger">*</span></label>
                    <input type="number" class="form-control text-center" id="monthsToPay" oninput="changePriceValue()" id="onthsPay" min="1" name="amounthMonthPay" value="{{ $amounthMonthPay }}">
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
            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-md modal-dialog-centered "  role="document">
                <div class="modal-content">
                  
                  <div class="modal-header">
                    <h5 class="modal-title w-100 text-center" id="exampleModalLongTitle">Generando pagos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>

                  <div class="modal-body">
                    <table class="table">
                      <tbody>
                        <tr>
                          <td class="text-left"><i class="fa fa-user mr-1" aria-hidden="true"></i>Usuario</td>
                          <td class="text-right">{{ $userSelected->getFullNameAttribute() }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><i class="fa fa-dollar-sign mr-1" aria-hidden="true"></i>Abonado</td>
                          <td class="text-right">$ <p class="d-inline" id="valuePrice"></p></td>
                        </tr>
                        <tr>
                          <td class="text-left"><i class="fa fa-calendar mr-1" aria-hidden="true"></i>Fecha</td>
                          <td class="text-right" id="valueDate"></td>
                        </tr>
                        <tr>
                          <td class="text-left"><i class="fa fa-flag mr-1" aria-hidden="true"></i>Plan activo</td>
                          <td class="text-right">{{ $subscription->name }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><i class="fa fa-lightbulb mr-1" aria-hidden="true"></i>Estado del pago</td>
                          <td class="text-right"><p id="valueStatus" class="d-inline"></p></td>
                        </tr>                          
                      </tbody>
                    </table>
                    
                    <hr>
                    
                    <span class="text-danger"><i class="fa fa-exclamation-triangle mr-1 mb-1" aria-hidden="true"></i></span>
                    <div class="text-center">             
                      @if($amounthMonthPay != 1)
                        <p class="d-inline">Cantidad de pagos a generar: <span class="font-weight-bold" id="valueInput"></span></p> 
                        <p>Los pagos se generaran a partir de <span id="monthToPay" class="font-weight-bold"></span></p>
                      @else 
                        <p>Se generara el pago en este mes <span id="monthToPay" class="font-weight-bold"></span></p>
                      @endif
                    </div>
                  </div>
                  <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-check mr-1" aria-hidden="true"></i>Confirmar</button>
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

$(document).ready(function () {
      $('#select2').select2({
              lenguage: 'es',
              theme: 'bootstrap4',
              width: '100%',
        });
    });
      
   function getValueInput (){
      //recupero los valores
      var toPay = document.getElementById("priceInput").value;
      var paymentStatus = document.getElementById("statusPayment").value;

      var date = document.getElementById("date").value;
      var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
      var newDate = new Date(date).toLocaleDateString("es-Es", options);
      
      //asigno valores al modal
      document.getElementById("valuePrice").textContent = toPay;
      document.getElementById("valueDate").textContent = newDate;
      
      //harcodeadeado
      if (paymentStatus == 1){
        document.getElementById("valueStatus").textContent = "Pendiente"; 
      }      
      if (paymentStatus == 2){
        document.getElementById("valueStatus").textContent = "Pagado"; 
      }
      if (paymentStatus == 3){
        document.getElementById("valueStatus").textContent = "Cancelado"; 
      }   
      
      if (document.getElementById("valueInput") != null){
        var monthsToPay = document.getElementById("monthsToPay").value; 
        document.getElementById("valueInput").textContent = monthsToPay;
        document.getElementById("monthToPay").textContent = new Date(date).toLocaleDateString("es-Es", {month: 'long'}) + " inclusive";
      }

      if (document.getElementById("monthToPay") != null){
        document.getElementById("monthToPay").textContent = new Date(date).toLocaleDateString("es-Es", {month: 'long'});
      }

    }
   
</script>
@endsection
