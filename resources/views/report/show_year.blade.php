@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Registro del año: {{ $year }}</h1>

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

    <div class="row">
        <!-- Cantidad de pagos -->
        <div class="col-xl-3 col-md-6 mb-2">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">{{ __('Cantidad de pagos') }}</div>                            
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $payments->count() }}</div>
                        </div> 
                        <div class="col-auto" id="eyeMonthly">
                            <i class="fa fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- payments generated -->
        <div class="col-xl-3 col-md-6 mb-2">      
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{ __('Dinero recaudado') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="eyeAnnualDiv">${{ $paymentGenerated }}</div>
                        </div>
                        <div class="col-auto" id="eyeAnnual">
                            <i class="fa fa-sack-dollar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- New users -->
        <div class="col-xl-3 col-md-6 mb-2">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">{{ __('Usuarios nuevos') }}</div>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $users->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assistances -->
        <div class="col-xl-3 col-md-6 mb-2">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{ __('Asistencias registradas') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Empty</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="mb-4">

    <!-- Renevue x month chart -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow ">
                <div class="card-body">
                    <canvas id="revenuePerMonth" width="400" height="400"></canvas>
                </div> 
            </div>   
        </div>
    </div>

    <!-- Payments table -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-danger"> Pagos registrados en el año: {{ $year }}</h6>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover text-center" id="tableLastPayments">    
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Abonado</th>
                                <th>Fecha</th>
                                <th>Plan</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                                <th>Cambiar estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    @if($payment->userSubscription->user != NULL)
                                        <td>{{ $payment->userSubscription->user->getFullNameAttribute() }}</td>
                                    @endif
                                    <th>${{ $payment->price }}</th>
                                    <td data-sort="{{ strtotime($payment->date) }}">{{ $payment->date->format('d/m/Y') }}</td> 
                                    <td>{{ $payment->userSubscription->subscription->name }}</td>                                    
                                    <td><h5><span class="badge badge-pill badge-{{$payment->paymentStatus->color}}">{{ $payment->paymentStatus->name }}</span></h5></td>                                    
                                    <td class="text-center d-flex justify-content-center">                                    
                                        <a href="{{ route('payment.edit', ['payment_id' => $payment->id]) }}" type="button" class="btn btn-circle btn-secondary" title="Edit" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
                                        <div>
                                            <form action="{{ route('payment.destroy', ['payment_id' => $payment->id]) }}" method="POST"> 
                                                @csrf 
                                                @method("DELETE") 
                                                <button type="submit" class="btn btn-circle btn-danger ml-2" onclick="return confirm('¿Desea borrar pago seleccionado?')" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></button> 
                                            </form>  
                                        </div>                          
                                    </td>  
                                    <td>  
                                        <form action="{{ route('payment.changeStatus', ['payment_id' => $payment->id]) }}" method="GET">
                                            <select class="custom-select" style="text-align:center;" onChange="this.form.submit()" name="new_payment_status_id" value="old(new_payment_status_id)">                                           
                                                @foreach($paymentStatuses as $paymentStatus)    
                                                    <option value="{{ $paymentStatus->id }}"  {{($payment->paymentStatus->id === $paymentStatus->id) ? 'Selected' : ''}}>{{ $paymentStatus->name }}</option>
                                                @endforeach
                                            </select>   
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

    <!-- New users -->
    <div class="row">
        <div class="col mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-danger">Lista de usuarios registrados en: {{ $year }}</h6>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover text-center" id="userTable">    
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Telefono</th>
                                <th>Plan</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->getFullNameAttribute() }}</td>
                                    @if($user->primary_phone != NULL)
                                        <td>{{ $user->primary_phone }}</td>
                                    @else
                                        <td> - </td>
                                    @endif
                                    @if($user->lastSubscription()->first() != null)                                 
                                        <td><h5><span class="badge badge-pill badge-dark">{{ $user->lastSubscription()->first()->name}}</span></h5></td>
                                    @else
                                        <td><h5><span class="badge badge-pill badge-dark">{{ __('Sin plan') }}</span></h5></td>
                                    @endif
                                    <td class="d-flex justify-content-center">
                                        <a href="{{ route('profile.show', ['profile_id' => $user->id]) }}" type="button" title="Ver usuario" class="btn btn-circle btn-light mx-1"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('profile.edit', ['profile_id' => $user->id]) }}" type="button" title="Editar usuario" class="btn btn-circle btn-secondary mx-1"><i class="fa fa-pencil"></i></a>
                                        <div class="mx-1">
                                            <form action="{{ route('profile.destroy', ['profile_id' => $user->id]) }}" method="POST">
                                                @csrf
                                                @method("DELETE")
                                                <button class="btn btn-circle btn-danger" onclick="return confirm('¿Desea borrar al usuario {{$user->name}}?')"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </div>
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

    //Payments table
    $(document).ready(function () {
        $('#tableLastPayments').DataTable( {
            order: [[0, 'asc']],
        })
    });

    //User table
    $(document).ready(function () {
        $('#userTable').DataTable( {
            order: [[0, 'asc']],
        })
    });
    
    //select2
    $(document).ready(function () {
        $('#select2').select2({
                lenguage: 'es',
                theme: 'bootstrap4',
                width: '100%',
        });
    });  
</script>

<script>
    //Payments x month chart

    // Utils.months({ count:7 });
    const months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    
    const revenuePerMonth = <?php echo json_encode(array_values($array)) ?>;
    // [65, 59, 80, 81, 56, 55, 40, 10, 20, 30, 44, 10]
    

    const data = {
        labels: months,
        datasets: [{
            label: 'Pagos registrados',
            data: revenuePerMonth,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(201, 203, 207, 0.2)'
            ],
            borderColor: [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)'
            ],
            borderWidth: 1
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive:true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
    };

    const myChart = new Chart( document.getElementById('revenuePerMonth'), config);

</script>
@endsection
