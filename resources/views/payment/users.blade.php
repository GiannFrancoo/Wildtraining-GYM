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


    <!--<div class="table-responsive">
                    <table class="table table-bordered table-hover text-center" id="myTable"> 


                    </table>
    </div>-->

    
    
    
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
                    <!--<a id="generate" class="btn btn-primary" value="{{$user->id}}">{{$user->name}}</a>-->
                    
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
  <!--<a href="#" class="list-group-item list-group-item-action active" aria-current="true">-->

<!--
    <html>
  <body>
    <div id="container"></div>
    <br>
    <div>

    <ul class="list-group">
        @foreach($users as $user)
            <button id="generate" value="{{$user->id}}">{{$user->name}}</button>
        @endforeach
    </ul>


   


    <select id="mySelect" onchange="myFunction()">
        @foreach($users as $user)
            <option value="{{$user->id}}" id="abc">{{$user->name}}</option>
        @endforeach
    </select>-->




 <!--   <p id="demo"></p>
    <p>hola</p>
    <p type="text" value="demo"></p>


     <script>
        function myFunction() {
        var x = document.getElementById("mySelect").value;
            document.getElementById("demo").innerHTML = "La id del usuario es: " + x;
            console.log(document.getElementById("mySelect"));
        };
       
    </script>-->
    

  <!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<select id="independent">
  <option value="A"> A </option>
  @foreach($users as $user)
  <option value="{{$user->id}}">
    {{$user->name}}
  </option>
        @endforeach
  
</select>

<select id="dependent">
  <option value="A021">    A1 </option>
  <option value="A22019">  A2 </option>
  <option value="A3541">   A3 </option>
  <option value="B148">    B1 </option>
  <option value="B2">      B2 </option>
  <option value="B397415"> B3 </option>
</select>

<script>
$(function() {
    $('#independent').on('change', function (e) {

      var selected = $('#independent').val().toUpperCase();
      var currentDep = $('#dependent').val().charAt(0).toUpperCase();
      var changedSelected = false;

      $('#dependent option').each(function() {

        var opt = $(this);
        var value = opt.val().charAt(0).toUpperCase();

        if (value !== selected) {

          opt.addClass('hide');
          opt.removeAttr('selected');

        } else {

          opt.removeClass('hide');

          if (!changedSelected) {

            opt.attr('selected', 'selected');
            changedSelected = true;

          } else {
            opt.removeAttr('selected');
          }
        }
      });
    });
});

</script>-->




        <!--<div class="col-lg-6 -sm-10 mb-4">
            <div class="form-group focused">
                <label class="form-control-label" for="social_work_id">Generar pago a:</label>
                <select class="custom-select"  name="social_work_id">                                           
                    @foreach($users as $user)
                        <li class selected id="generate" value="{{$user->id}}">{{$user->name}}</li>
                    @endforeach
                </select>
            </div>
        </div>-->

<!--
<script>

document.getElementById('generate').onclick = function() {
 
 var values = ["dog", "cat", "parrot", "rabbit"];

 var select = document.createElement("select");
 select.name = "pets";
 select.id = "pets"

 for (const val of values)
 {
     var option = document.createElement("option");
     option.value = val;
     option.text = val.charAt(0).toUpperCase() + val.slice(1);
     select.appendChild(option);
 }

 var label = document.createElement("label");
 label.innerHTML = "Choose your pets: "
 label.htmlFor = "pets";

 document.getElementById("container").appendChild(label).appendChild(select);
}

</script>-->



@endsection
