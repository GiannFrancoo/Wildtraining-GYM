@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Pago') }}</h1>





    <!--<div class="table-responsive">
                    <table class="table table-bordered table-hover text-center" id="myTable"> 


                    </table>
    </div>-->

    
    
    
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6">
            <input type="text" id="myInput" onkeyup="tableSearch()" class="form-control" placeholder="Nombre de usuario&hellip;">
        </div>
    </div>
    
    <table class="table table-bordered table-hover text-center col-lg-3" id="myTable">    
        <div class="list-group col-lg-3">
        <thead>
            <tr>
                <th scope="col">Seleccione la persona para generar el pago</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td><a href="{{route('payment.userSelected', ['payment_id' => $user->id])}}" class="list-group-item list-group-item-action">{{$user->name}}</a></td>
            </tr>
                <!--<a id="generate" class="btn btn-primary" value="{{$user->id}}">{{$user->name}}</a>-->
                
            @endforeach
        </tbody>    
        </div>
    </table> 
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
