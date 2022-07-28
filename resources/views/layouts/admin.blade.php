<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Laravel SB Admin 2">
    <meta name="author" content="Alejandro RH">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.png') }}" rel="icon" type="image/png">

    <!-- Icons -->
    <script src="https://kit.fontawesome.com/d8957ec940.js" crossorigin="anonymous"></script>

    <!-- DataTables -->
    <link href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

</head>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">  
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fa fa-dumbbell"></i>
            </div>            
            <div class="sidebar-brand-text mx-3">Wildtraining</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            {{ __('General') }}
        </div>

        <!-- Nav Item - Panel -->
        <li class="nav-item {{ Nav::isRoute('home') }}">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>{{ __('Panel') }}</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            {{ __('Administración') }}
        </div>

        <!-- Nav Item - Users -->
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#collapseUsers" role="button" aria-expanded="false" aria-controls="collapseUsers">
                <i class="fa-solid fa-users"></i>
                <span>{{ __('Usuarios') }}</span>
            </a>
        </li>
        <div class="collapse ml-2" id="collapseUsers">
            <!-- Add new user -->
            <li class="nav-item {{ Nav::isRoute('profile.create') }}">
                <a class="nav-link" href="{{ route('profile.create') }}">
                    <i class="fa-solid fa-add"></i>
                    <span>{{ __('Agregar nuevo usuario') }}</span>
                </a>
            </li>
            <!-- List of users who left -->
            <li class="nav-item {{ Nav::isRoute('profile.usersWhoLeft') }}">
                <a class="nav-link" href="{{ route('profile.usersWhoLeft') }}">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span>{{ __('Usuarios que dejaron') }}</span>
                </a>
            </li>
            <!-- change user subscription  -->
            <li class="nav-item {{ Nav::isRoute('profile.changeSubscription') }}">
                <a class="nav-link" href="{{ route('profile.changeSubscription') }}">
                    <i class="fa-solid fa-arrow-right-arrow-left"></i>
                    <span>{{ __('Cambiar suscripcion') }}</span>
                </a>
            </li>
            <!-- List of users -->
            <li class="nav-item {{ Nav::isRoute('profile.index') }}">
                <a class="nav-link" href="{{ route('profile.index') }}">
                    <i class="fa-solid fa-list"></i>
                    <span>{{ __('Lista de usuarios') }}</span>
                </a>
            </li>
        </div>

        <!-- Nav Item - Subscriptions -->
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#collapseSubscriptions" role="button" aria-expanded="false" aria-controls="collapseSubscriptions">
                <i class="fa-solid fa-calendar"></i>
                <span>{{ __('Suscripciones') }}</span>
            </a>
        </li>
        <div class="collapse ml-2" id="collapseSubscriptions">
            <!-- Add new subscription -->
            <li class="nav-item {{ Nav::isRoute('subscription.create') }}">
                <a class="nav-link" href="{{ route('subscription.create') }}">
                    <i class="fa-solid fa-add"></i>
                    <span>{{ __('Agregar nueva suscripción') }}</span>
                </a>
            </li>
            <!-- List of subscriptions -->
            <li class="nav-item {{ Nav::isRoute('subscription.index') }}">
                <a class="nav-link" href="{{ route('subscription.index') }}">
                    <i class="fa-solid fa-list"></i>
                    <span>{{ __('Lista de suscripciones') }}</span>
                </a>
            </li>        
        </div>

        <!-- Nav Item - Assistances -->
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#collapseAssistances" role="button" aria-expanded="false" aria-controls="collapseAssistances">
                <i class="fa-solid fa-clipboard-list"></i>
                <span>{{ __('Asistencias') }}</span>
            </a>
        </li>
        <div class="collapse ml-2" id="collapseAssistances">
            <!-- Add new assistance -->
            <li class="nav-item {{ Nav::isRoute('assistance.create') }}">
                <a class="nav-link" href="{{ route('assistance.create') }}">
                    <i class="fa-solid fa-add"></i>
                    <span>{{ __('Marcar nueva asistencia') }}</span>
                </a>
            </li>
            <!-- List of assistances -->
            <li class="nav-item {{ Nav::isRoute('assistance.index') }}">
                <a class="nav-link" href="{{ route('assistance.index') }}">
                    <i class="fa-solid fa-list"></i>
                    <span>{{ __('Lista de asistencias') }}</span>
                </a>
            </li>
        </div>

        <!-- Nav Item - Payments -->
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#collapsePayments" role="button" aria-expanded="false" aria-controls="collapsePayments">
                <i class="fa-solid fa-fw fa fa-money"></i>
                <span>{{ __('Pagos') }}</span>
            </a>
        </li>
        <div class="collapse ml-2" id="collapsePayments">
            <!-- Add new payment -->
            <li class="nav-item {{ Nav::isRoute('payment.create') }}">
                <a class="nav-link" href="{{ route('payment.create') }}">
                    <i class="fa-solid fa-add"></i>
                    <span>{{ __('Generar nuevo pago') }}</span>
                </a>
            </li>
            <!-- List of pendant payments -->
            <li class="nav-item {{ Nav::isRoute('payment.pendant') }}">
                <a class="nav-link" href="{{ route('payment.pendant') }}">
                    <i class="fa-solid fa-list"></i>
                    <span>{{ __('Pendientes') }}</span>
                </a>
            </li>
            <!-- List of payments -->
            <li class="nav-item {{ Nav::isRoute('payment.index') }}">
                <a class="nav-link" href="{{ route('payment.index') }}">
                    <i class="fa-solid fa-list"></i>
                    <span>{{ __('Lista todos los pagos') }}</span>
                </a>
            </li>
        </div>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            {{ __('Contacto') }}
        </div>

        <!-- Nav Item - About -->
        <li class="nav-item {{ Nav::isRoute('about') }}">
            <a class="nav-link" href="{{ route('about') }}">
                <i class="fa-solid fa-handshake-angle"></i>
                <span>{{ __('Sobre nosotros') }}</span>
            </a>
        </li>

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline mt-3">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

        </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                            <figure class="img-profile rounded-circle avatar font-weight-bold" data-initial="{{ Auth::user()->name[0] }}"></figure>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('profile', ['profile_id' => Auth::user()->id]) }}">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                {{ __('Perfil') }}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                {{ __('Cerrar sesion') }}
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                @yield('main-content')

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; | Bentivegna Gian Franco - Cervelli Haderne Lucas | {{ now()->year }}</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->
</div>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('¿Desea cerrar sesion?') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Si desea cerrar la sesion presione el botónn cerrar sesión.</div>
            <div class="modal-footer">
                <button class="btn btn-link" type="button" data-dismiss="modal">{{ __('Cancelar') }}</button>
                <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Cerrar sesion') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

<script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js' )}}"></script>

<script>
    function tableSearch() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

<script>
    $.extend(true, $.fn.dataTable.defaults, {
        bInfo: false,
        order: [[0, 'desc']],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
        },
    });

    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
    }, 5000);
</script>

@yield('custom_js')

</body>
</html>