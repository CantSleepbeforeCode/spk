@extends('base.admin')
@section('content')
    <div class="pcoded-content">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Beranda</h5>
                            <p class="m-b-0">Selamat datang, {{ Auth::user()->username }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/admin/beranda"> <i class="fa fa-home"></i> </a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Beranda</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page-header end -->
        <div class="pcoded-inner-content">
            <!-- Main-body start -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- Page-body start -->
                    <div class="page-body">
                        <div class="row">
                            <div class="col">
                                <div class="card bg-c-blue total-card">
                                    <div class="card-block">
                                        <div class="text-left">
                                            <h4>{{$registered}}</h4>
                                            <p class="m-0">Peserta Mendaftar</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card bg-c-red total-card">
                                    <div class="card-block">
                                        <div class="text-left">
                                            <h4>{{$rejected}}</h4>
                                            <p class="m-0">Peserta Tidak Lolos</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card bg-c-green total-card">
                                    <div class="card-block">
                                        <div class="text-left">
                                            <h4>{{$accepted}}</h4>
                                            <p class="m-0">Peserta Lolos</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Page-body end -->
                </div>
                <div id="styleSelector"> </div>
            </div>
        </div>
    </div>
@endsection
