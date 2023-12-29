@extends('base.admin')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>

    <script>
        new DataTable('#table');
    </script>
@endsection

@section('content')
    <div class="pcoded-content">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Bobot</h5>
                            <p class="m-b-0">Daftar Bobot untuk penilaian Calon Peserta</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/admin/beranda"> <i class="fa fa-home"></i> </a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Bobot</a>
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

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="row mb-2">
                            <div class="col ">
                                <button class="btn btn-primary float-right" data-toggle="modal"
                                data-target="#addModal">Tambah</button>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5>Data Bobot</h5>
                                <div class="card-header-right">
                                    <ul class="list-unstyled card-option">
                                        <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                        <li><i class="fa fa-window-maximize full-card"></i></li>
                                        <li><i class="fa fa-minus minimize-card"></i></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-block table-border-style">
                                <div class="table-responsive">
                                    <table class="table" id="table">
                                        <thead>
                                            <tr>
                                                <th>Kategori</th>
                                                <th>Sub Kategori</th>
                                                <th>Deskripsi</th>
                                                <th>Nilai</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bobots as $bobot)
                                                <tr>
                                                    @if ($bobot->kategori == 'jas')
                                                        <td>JASMANI</td>
                                                    @elseif($bobot->kategori == 'min')
                                                        <td>ADMINISTRASI</td>
                                                    @elseif($bobot->kategori == 'kes')
                                                        <td>KESEHATAN</td>
                                                    @endif
                                                    <td>{{ $bobot->sub_kategori }}</td>
                                                    <td>{{ $bobot->deskripsi }}</td>
                                                    <td>{{ $bobot->nilai }}</td>
                                                    <td>
                                                        <button class="btn btn-sm ml-2 mb-2 btn-warning" data-toggle="modal"
                                                            data-target="#editModal{{ $bobot->bobot_id }}">Edit</button>
                                                            <button class="btn btn-sm ml-2 mb-2 btn-danger"
                                                                data-toggle="modal"
                                                                data-target="#deleteModal{{ $bobot->bobot_id }}">Hapus</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Page-body end -->
                    
                    <div class="modal fade" id="addModal" tabindex="-1" role="dialog"
                        aria-labelledby="assignModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="assignModalLabel">Tambah Data
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="/admin/tambah-bobot" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                          <label>Kategori</label>
                                          <select name="kategori" class="form-control" required>
                                            <option value="">--- Pilih Kategori ---</option>
                                            <option value="jas">JASMANI</option>
                                            <option value="min">ADMINISTRASI</option>
                                            <option value="kes">KESEHATAN</option>
                                          </select>
                                        </div>
                                        <div class="form-group">
                                          <label>Sub Kategori</label>
                                          <input type="text" name="sub_kategori" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                          <label>Deskripsi</label>
                                          <input type="text" name="deskripsi" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                          <label>Nilai</label>
                                          <input type="number" name="nilai" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Kirim</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @foreach ($bobots as $bobot)     
                    <div class="modal fade" id="editModal{{$bobot->bobot_id}}" tabindex="-1" role="dialog"
                        aria-labelledby="assignModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="assignModalLabel">Ubah Data
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="/admin/ubah-bobot" method="POST">
                                    @csrf
                                    <input type="hidden" name="bobot" value="{{$bobot->bobot_id}}">
                                    <div class="modal-body">
                                        <div class="form-group">
                                          <label>Kategori</label>
                                          <select name="kategori" class="form-control" required>
                                            <option value="">--- Pilih Kategori ---</option>
                                            <option value="jas" @if($bobot->kategori == 'jas') selected @endif>JASMANI</option>
                                            <option value="min" @if($bobot->kategori == 'min') selected @endif>ADMINISTRASI</option>
                                            <option value="kes" @if($bobot->kategori == 'kes') selected @endif>KESEHATAN</option>
                                          </select>
                                        </div>
                                        <div class="form-group">
                                          <label>Sub Kategori</label>
                                          <input type="text" name="sub_kategori" class="form-control" value="{{$bobot->sub_kategori}}" required>
                                        </div>
                                        <div class="form-group">
                                          <label>Deskripsi</label>
                                          <input type="text" name="deskripsi" class="form-control" value="{{$bobot->deskripsi}}" required>
                                        </div>
                                        <div class="form-group">
                                          <label>Nilai</label>
                                          <input type="number" name="nilai" class="form-control" value="{{$bobot->nilai}}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Kirim</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                         
                    <div class="modal fade" id="deleteModal{{$bobot->bobot_id}}" tabindex="-1" role="dialog"
                        aria-labelledby="assignModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="assignModalLabel">Hapus Data
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                    <div class="modal-body">
                                        anda yakin ingin menghapus bobot ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Tutup</button>
                                        <a href="/admin/hapus-bobot/{{$bobot->bobot_id}}" class="btn btn-danger">Iya, Hapus</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div id="styleSelector"> </div>
                </div>
            </div>
        </div>
    @endsection
