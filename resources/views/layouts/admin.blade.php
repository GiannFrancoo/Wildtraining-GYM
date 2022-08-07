<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Wildtraining app">
    <meta name="author" content="Bentivegna Gian Franco - Cervelli Lucas Haderne">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Wildtraining') }}</title>

    <!-- Fonts -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.png') }}" rel="icon" type="image/png">

    <!-- Icons -->
    <script src="https://kit.fontawesome.com/d8957ec940.js" crossorigin="anonymous"></script>
    
    <!-- ChartJs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- DataTables -->
    <link href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"> 

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
    
</head>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">  
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fa fa-dumbbell"></i>
            </div>            
            <div class="sidebar-brand-text mx-3 text-danger">Wildtraining</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            {{ __('General') }}
        </div>

        <!-- Nav Item - Panel -->
        <li class="nav-item {{ Nav::isRoute('home') }}">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="fa fa-gauge-high"></i>
                <span>{{ __('Panel') }}</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            {{ __('Administración') }}
        </div>

        <!-- Nav Item - Users -->
        <li class="nav-item {{ Nav::isRoute('profile.*') }}">
            <a class="nav-link" data-toggle="collapse" href="#collapseUsers" role="button" aria-expanded="false" aria-controls="collapseUsers">
                <i class="fa-solid fa-users"></i>
                <span>{{ __('Usuarios') }}</span>
            </a>
        </li>
        <div class="collapse ml-1 {{ Nav::isRoute('profile.*', 'show') }}" id="collapseUsers">
            <div class="border-left-light collapse-inner">
                <!-- Add new user -->
                <li class="nav-item {{ Nav::isRoute('profile.create') }}">
                    <a class="nav-link" href="{{ route('profile.create') }}">
                        <i class="fa-solid fa-add"></i>
                        <span>{{ __('Nuevo') }}</span>
                    </a>
                </li>
                <!-- List of users who left -->
                <li class="nav-item {{ Nav::isRoute('profile.usersWhoLeft') }}">
                    <a class="nav-link" href="{{ route('profile.usersWhoLeft') }}">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>{{ __('Dejaron') }}</span>
                    </a>
                </li>
                <!-- change user subscription  -->
                <li class="nav-item {{ Nav::isRoute('profile.changeSubscription') }}">
                    <a class="nav-link" href="{{ route('profile.changeSubscription') }}">
                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                        <span>{{ __('Cambiar plan') }}</span>
                    </a>
                </li>
                <!-- List of users -->
                <li class="nav-item {{ Nav::isRoute('profile.index') }}">
                    <a class="nav-link" href="{{ route('profile.index') }}">
                        <i class="fa-solid fa-list"></i>
                        <span>{{ __('Listado') }}</span>
                    </a>
                </li>
            </div>
        </div>

        <!-- Nav Item - Subscriptions -->
        <li class="nav-item {{ Nav::isRoute('subscription.*') }}">
            <a class="nav-link" data-toggle="collapse" href="#collapseSubscriptions" role="button" aria-expanded="false" aria-controls="collapseSubscriptions">
                <i class="fa-solid fa-calendar"></i>
                <span>{{ __('Planes') }}</span>
            </a>
        </li>
        <div class="collapse ml-1 {{ Nav::isRoute('subscription.*', 'show') }}" id="collapseSubscriptions">
            <div class="border-left-light collapse-inner">
                <!-- Add new subscription -->
                <li class="nav-item {{ Nav::isRoute('subscription.create') }}">
                    <a class="nav-link" href="{{ route('subscription.create') }}">
                        <i class="fa-solid fa-add"></i>
                        <span>{{ __('Nuevo') }}</span>
                    </a>
                </li>
                <!-- List of subscriptions -->
                <li class="nav-item {{ Nav::isRoute('subscription.index') }}">
                    <a class="nav-link" href="{{ route('subscription.index') }}">
                        <i class="fa-solid fa-list"></i>
                        <span>{{ __('Listado') }}</span>
                    </a>
                </li> 
            </div>       
        </div>

        <!-- Nav Item - Assistances -->
        <li class="nav-item {{ Nav::isRoute('assistance.*') }}">
            <a class="nav-link" data-toggle="collapse" href="#collapseAssistances" role="button" aria-expanded="false" aria-controls="collapseAssistances">
                <i class="fa-solid fa-clipboard-list"></i>
                <span>{{ __('Asistencias') }}</span>
            </a>
        </li>
        <div class="collapse ml-1 {{ Nav::isRoute('assistance.*', 'show') }}" id="collapseAssistances">
            <div class="border-left-light collapse-inner">
                <!-- Add new assistance -->
                <li class="nav-item {{ Nav::isRoute('assistance.create') }}">
                    <a class="nav-link" href="{{ route('assistance.create') }}">
                        <i class="fa-solid fa-add"></i>
                        <span>{{ __('Nueva') }}</span>
                    </a>
                </li>                
                <!-- List of assistances today -->
                <li class="nav-item {{ Nav::isRoute('assistance.todayAssistances') }}">
                    <a class="nav-link" href="{{ route('assistance.todayAssistances') }}">
                        <i class="fa-solid fa-check"></i>
                        <span>{{ __('Hoy') }}</span>
                    </a>
                </li>
                <!-- List of assistances -->
                <li class="nav-item {{ Nav::isRoute('assistance.index') }}">
                    <a class="nav-link" href="{{ route('assistance.index') }}">
                        <i class="fa-solid fa-list"></i>
                        <span>{{ __('Listado') }}</span>
                    </a>
                </li>
            </div>
        </div>

        <!-- Nav Item - Payments -->
        <li class="nav-item {{ Nav::isRoute('payment.*') }}">
            <a class="nav-link" data-toggle="collapse" href="#collapsePayments" role="button" aria-expanded="false" aria-controls="collapsePayments">
                <i class="fa-solid fa-fw fa fa-money"></i>
                <span>{{ __('Pagos') }}</span>
            </a>
        </li>
        <div class="collapse ml-1 {{ Nav::isRoute('payment.*', 'show') }}" id="collapsePayments">            
            <div class="border-left-light collapse-inner">
                <!-- Add new payment -->
                <li class="nav-item {{ Nav::isRoute('payment.create') }}">
                    <a class="nav-link" href="{{ route('payment.create') }}">
                        <i class="fa-solid fa-add"></i>
                        <span>{{ __('Nuevo') }}</span>
                    </a>
                </li>
                <!-- List of pending payments -->
                <li class="nav-item {{ Nav::isRoute('payment.pending') }}">
                    <a class="nav-link" href="{{ route('payment.pending') }}">
                        <i class="fa-solid fa-clock"></i>
                        <span>{{ __('Pendientes') }}</span>
                    </a>
                </li>
                <!-- List of payments -->
                <li class="nav-item {{ Nav::isRoute('payment.index') }}">
                    <a class="nav-link" href="{{ route('payment.index') }}">
                        <i class="fa-solid fa-list"></i>
                        <span>{{ __('Listado') }}</span>
                    </a>
                </li>
            </div>
        </div>

        <!-- Nav Item - Reports -->
        <li class="nav-item {{ Nav::isRoute('Reports.*') }}">
            <a class="nav-link" data-toggle="collapse" href="#collapseReports" role="button" aria-expanded="false" aria-controls="collapseReports">
                <i class="fa fa-bar-chart"></i>
                <span>{{ __('Reportes') }}</span>
            </a>
        </li>
        <div class="collapse ml-1 {{ Nav::isRoute('report.*', 'show') }}" id="collapseReports"> 
            <div class="border-left-light collapse-inner">
                <!-- Report date -->
                <li class="nav-item {{ Nav::isRoute('report.index') }}">
                    <a class="nav-link" href="{{ route('report.index') }}">
                        <i class="fa-solid fa-calendar"></i>
                        <span>{{ __('Mensual') }}</span>
                    </a>
                </li>
            </div>
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
                            <figure class="img-profile rounded-circle avatar bg-danger font-weight-bold" data-initial="{{ Auth::user()->name[0] }}"></figure>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fa-solid fa-arrow-right-from-bracket mr-1 text-gray-400"></i>
                                {{ __('Cerrar sesión') }}
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
                <h5 class="modal-title" id="exampleModalLabel">{{ __('¿Desea cerrar sesión?') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">{{ __('Si desea cerrar la sesión presione el botón cerrar sesión') }}</div>
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

<!-- Data tables -->
<script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
    $.extend(true, $.fn.dataTable.defaults, {
        bInfo: false,
        order: false,
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

<!-- script para cerrar barra por default en mobile -->
<script>
    $(document).ready(function () {
        var $window = $(window);
        var $panel = $('#pane1');
        function checkWidth() {
            var windowsize = $window.width();
            if (windowsize < 768) {
                $('#accordionSidebar').addClass('toggled');
            }
        }
        checkWidth();
    });
</script>

@yield('custom_js')

</body>
</html>