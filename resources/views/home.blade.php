@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Panel de administración') }}</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success border-left-success" role="alert">
            {{ session('status') }}
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

    <!-- Card headers -->
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a onclick="hiddenMonthly()">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1" id="ganancia">Ganancia (Mensual)</div>                            
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="eyeMonthlyDiv">******</div>
                            </div> 
                            <div class="col-auto" id="eyeMonthly">
                                <i class="fa fa-eye-slash fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">            
            <a onclick="hiddenAnnual()">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Ganancia (Anual)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="eyeAnnualDiv">******</div>
                            </div>
                            <div class="col-auto" id="eyeAnnual">
                                <i class="fa fa-eye-slash fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Pending payments -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('payment.pending') }}" class="text-decoration-none">
                <div class="card border-left-dark shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">{{ __('Pendiente a pago') }}</div>
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $pendingPayments->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Total Users -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('profile.index') }}" class="text-decoration-none">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total usuarios / Sin plan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users->count() }} / {{ $usersWithoutSubscription }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <hr class="mb-4">


    <!-- Last payments table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-danger">{{ __('Ultimos pagos registrados') }}</h6>
                    <a href="{{ route('payment.create') }}" type="button" class="btn btn-dark" title="add" method="GET" data-toggle="tooltip"><i class="fa fa-add mr-1"></i>{{ __('Nuevo pago') }}</a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover text-center" id="tableLastPayments">    
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Plan</th>
                                <th>Acciones</th>
                                <th>Cambiar estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>{{ $payment->userSubscription->user->getFullNameAttribute() }}</td>
                                    <td data-sort="{{ strtotime($payment->date) }}">{{ $payment->date->format('d/m/Y') }}</td>
                                    <td><h5><span class="badge badge-pill badge-{{$payment->paymentStatus->color}}">{{ $payment->paymentStatus->name }}</span></h5></td>
                                    <td>{{ $payment->userSubscription->subscription->name }}</td>       
                                    <td class="d-flex justify-content-center">
                                        <a href="{{ route('payment.edit', ['payment_id' => $payment->id]) }}" type="button" class="btn btn-secondary btn-circle mx-1" title="changeStatus" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
                                        <form action="{{ route('payment.destroy', ['payment_id' => $payment->id]) }}" method="POST" class="mx-1">
                                            @csrf
                                            @method("DELETE")
                                            <button class="btn btn-circle btn-danger ml-2" onclick="return confirm('¿Desea borrar el pago asociado a {{ $payment->userSubscription->user->getFullNameAttribute() }}?')" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></button>
                                        </form> 
                                    </td> 
                                    <td>
                                        <form action="{{ route('payment.changeStatus', ['payment_id' => $payment->id]) }}" method="GET" class="mx-1">
                                            <select class="custom-select" style="text-align:center;" onChange="this.form.submit()" name="paymentStatusSelect" value="">                                           
                                                @foreach($statusesPayments as $statusPayment)    
                                                    <option value="{{ $statusPayment->id }}"  {{($payment->paymentStatus->id === $statusPayment->id) ? 'Selected' : ''}}>{{ $statusPayment->name }}</option>
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

    <hr class="mb-4">

    <!-- Last users table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-danger">{{ __('Ultimos usuarios registrados') }}</h6>
                    <a href="{{ route('profile.create') }}" type="button" class="btn btn-dark" title="add" method="GET" data-toggle="tooltip"><i class="fa fa-add mr-1"></i>{{ __('Nuevo usuario') }}</a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover text-center" id="tableLastUsers">    
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Telefono</th>
                                <th>Plan</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users->take(5) as $user)
                                <tr>
                                    <td>{{ $user->getFullNameAttribute() }}</td>
                                    <td>{{ $user->primary_phone }}</td>
                                    <td>
                                        @if ($user->lastSubscription->isEmpty())
                                            <h5><span class="badge badge-pill badge-dark">Sin plan</span></h5>   
                                        @else
                                            <h5><span class="badge badge-pill badge-dark">{{ $user->lastSubscription->first()->name }} </span></h5>
                                        @endif 
                                    </td>
                                    <td class="d-flex justify-content-center">
                                        <a href="{{ route('profile.show', ['profile_id' => $user->id]) }}" type="button" class="btn btn-circle btn-light mx-1" title="Ver usuario"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('profile.edit', ['profile_id' => $user->id]) }}" type="button" class="btn btn-circle btn-secondary" title="Editar usuario"><i class="fa fa-pencil"></i></a>
                                        <form action="{{ route('profile.destroy', ['profile_id' => $user->id]) }}" method="POST">
                                            @csrf
                                            @method("DELETE")
                                            <button class="btn btn-circle btn-danger mx-1" onclick="return confirm('¿Desea borrar al usuario {{ $user->name }}?')" title="Borrar usuario"><i class="fa fa-trash"></i></button>
                                        </form>
                                        @if($user->lastSubscription()->first() != null)
                                            <a href="{{ route('payment.create', ['profile_id' => $user->id]) }}" type="button" class="btn btn-circle btn-success" title="Crear pago"><i class="fa fa-dollar"></i></a>
                                        @else
                                            <a href="{{ route('payment.create', ['profile_id' => $user->id]) }}" type="button" class="btn btn-circle btn-secondary" title="Crear pago"><i class="fa fa-dollar"></i></a>
                                        @endif
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
    $(document).ready(function () {
        $('#tableLastPayments').DataTable({
            order: [[1, 'desc']],
        })
        $('#tableLastUsers').DataTable({
            order: [[0, 'asc']],
        })
    })
</script>

<script>
    function hiddenMonthly() {        
        var hiddenText = "******";
        var monthlyRevenue = <?php echo json_encode(number_format($monthlyRevenue, 2, '.',',')); ?>;
        var div = document.getElementById("eyeMonthlyDiv");
        if (div.textContent == hiddenText){
            div.textContent = "$" + monthlyRevenue;
        }
        else {
            div.textContent = hiddenText;
        }
        $('#eyeMonthly').find("i").toggleClass("fa-eye fa-eye-slash");
    }

    function hiddenAnnual(){
        var hiddenText = "******";
        var anualRevenue = <?php echo json_encode(number_format($monthlyRevenue*12, 2, '.',',')); ?>;
        var div = document.getElementById("eyeAnnualDiv");
        if (div.textContent == hiddenText){
            div.textContent = "$" + anualRevenue;
        }
        else {
            div.textContent = hiddenText;
        }
        $('#eyeAnnual').find("i").toggleClass("fa-eye fa-eye-slash");
    }
</script>
@endsection