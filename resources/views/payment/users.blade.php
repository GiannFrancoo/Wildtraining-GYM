@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Pago') }}</h1>


    @if (session('error'))
        <div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
 
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6">
            <input type="text" id="myInput" onkeyup="tableSearch()" class="form-control" placeholder="Nombre de usuario&hellip;">
        </div>
    </div>
    
    <div class="row">
      <div class="col-12 col-md-4">
        <table class="table table-bordered table-hover text-center" id="myTable">    
          <div class="list-group">
            <thead>
                <tr>
                    <th scope="col">Seleccione la persona para generar el pago</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                  <form action="{{ route('payment.users') }}" method="GET">
                    <td><button type="submit" class="list-group-item list-group-item-action" name="user" value="{{ $user->id }}">{{ $user->name }}</button></td>
                  </form>
                </tr>                    
                @endforeach
            </tbody>    
          </div>
        </table> 
      </div>

      @if($selectedUser)
        <div class="col-12 col-md-8">
          <form action="{{ route('payment.store', ['payment_id' => $selectedUser->id])}}" method="POST">
            @csrf
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Crear pago</h6>
              </div>
              <div class="card-body">
                <h6 class="heading-small text-muted mb-4">Informacion</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-3 md-6 sm-8">
                      <div class="form-group focused">
                        <label class="form-control-label"  for="name">Precio<span class="small text-danger">*</span></label>       
                        <!--Input precio-->
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text">$</span>
                          </div>
                          <input type="number" required class="form-control" name="price" value="{{ $subscription->month_price }}">
                        </div>
                      </div>     
                    </div>
                    <div class="col-lg-6 md-8 sm-9">
                        <div class="form-group focused">
                            <label class="form-control-label" for="payment">Fecha<span class="small text-danger">*</span></label>
                            <input type="datetime-local" id="payment" required class="form-control" name="date" placeholder="payment" value="{{ now() }}">
                        </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-6 -sm-10 mb-4">
                      <div class="form-group focused">
                        <label class="form-control-label" for="new_password">Usuario que pago</label>
                        <input type="text" name="userSelected" class="form-control" readonly value="{{ $selectedUser->name }}">
                      </div>
                    </div>

                    <div class="col-lg-6 -sm-10 mb-4">
                      <div class="form-group">
                        <label class="form-control-label" for="new_password">Subscripcion</label>
                        <input type="text" class="form-control" readonly value="{{$subscription->name}}">
                      </div>
                    </div>
                  </div>
                  <!-- Button -->
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col text-center">
                        <button type="submit" class="btn btn-primary">Generar pago</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      @endif
    </div>
@endsection
