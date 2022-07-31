@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    
    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow mb-4">

                <div class="card-profile-image mt-4">
                    <img src="{{ asset('img/favicon.png') }}" class="rounded-circle" alt="user-image">
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12 mb-1">
                            <div class="text-center">
                                <p>Desarrolladores</p>
                                <h5 class="font-weight-bold">Bentivegna Gian Franco | Cervelli Haderne Lucas</h5>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-md-6 text-center">
                            <a href="https://www.instagram.com/gianfrancobentivegna" target="_blank" class="btn btn-circle btn-lg"><i class="fa-brands fa-instagram"></i></a>
                            <a href="https://www.linkedin.com/in/gianfrancobentivegna/" target="_blank" class="btn btn-circle btn-lg"><i class="fa-brands fa-linkedin"></i></a>
                            <p>Bentivegna Gian Franco</p>
                        </div>
                        <div class="col-md-6 text-center">
                            <a href="https://www.instagram.com/lucascervelli8/" target="_blank" class="btn btn-circle btn-lg"><i class="fa-brands fa-instagram"></i></a>
                            <a href="https://www.linkedin.com/in/gianfrancobentivegna/" target="_blank" class="btn btn-circle btn-lg"><i class="fa-brands fa-linkedin"></i></a>
                            <p>Cervelli Haderne Lucas</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h5 class="font-weight-bold">Plantilla utilizada: Laravel SB Admin 2</h5>
                            <p>SB Admin 2 for Laravel.</p>
                            <a href="https://github.com/GiannFrancoo/Wildtraining-GYM" target="_blank" class="btn btn-github">
                                <i class="fab fa-github fa-fw"></i> Repositorio
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

@endsection
