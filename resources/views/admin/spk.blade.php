@extends('base.admin')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $('#table').dataTable({
            ordering: false
        });
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
                            <h5 class="m-b-10">SPK</h5>
                            <p class="m-b-0">Halaman Pengambilan Keputusan Calon Peserta TNI AD</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/admin/beranda"> <i class="fa fa-home"></i> </a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">SPK</a>
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

                        <div class="card">
                            <div class="card-header">
                                <h5>Data Calon Peserta</h5>
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
                                                <th>Nomor Peserta</th>
                                                <th>Nama Lengkap</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Nomor Telepon</th>
                                                <th>Nilai UAN</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($participants as $participant)
                                                <tr>
                                                    <th scope="row">{{ $participant->nomor_peserta }}</th>
                                                    <td>{{ $participant->nama_lengkap }}</td>
                                                    <td>{{ $participant->jenis_kelamin }}</td>
                                                    <td>{{ $participant->nomor_telepon }}</td>
                                                    <td>{{ $participant->nilai_uan }}</td>
                                                    <td>
                                                        <button class="btn btn-sm ml-2 mb-2 btn-primary" data-toggle="modal"
                                                            data-target="#assignModal{{ $participant->id }}">Keputusan
                                                            Kelulusan</button>
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
                    @foreach ($participants as $participant)
                        <div class="modal fade" id="assignModal{{ $participant->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="assignModal{{ $participant->id }}Label" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="assignModal{{ $participant->id }}Label">Data
                                            <b>{{ $participant->nama_lengkap }}</b>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="/admin/beri-kelulusan" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $participant->id }}">
                                        <div class="modal-body">
                                            <div class="">
                                                <div class="mb-2">
                                                    <b>Data Pribadi</b>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">Nomor Peserta</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col">{{ $participant->nomor_peserta }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">Nama Lengkap</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col">{{ $participant->nama_lengkap }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">Kodim</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col">{{ $participant->kodim }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">Jenis Kelamin</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col">{{ $participant->jenis_kelamin }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">Tempat, Tanggal Lahir</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col">{{ $participant->tempat_lahir }},
                                                        {{ $participant->tanggal_lahir }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">Kode Panda</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col">{{ $participant->kode_panda }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">Tinggi Badan</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col">{{ $participant->tinggi_badan }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">Berat Badan</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col">{{ $participant->berat_badan }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">Agama</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col">{{ $participant->agama }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">Suku</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col">{{ $participant->suku }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">Alamat</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col">{{ $participant->alamat }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">Nomor Telepon</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col">{{ $participant->nomor_telepon }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">Nama Ortu</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col">{{ $participant->nama_ortu }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">Alamat Ortu</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col">{{ $participant->alamat_ortu }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">Pekerjaan Ortu</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col">{{ $participant->pekerjaan_ortu }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">Nama Wali</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col">{{ $participant->nama_wali }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">Sumber Info</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col">{{ $participant->sumber_info }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">Pendidikan</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col">{{ $participant->pendidikan }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">Nama Sekolah</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col">{{ $participant->nama_sekolah }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">Jurusan Dikum</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col">{{ $participant->jurusan_dikum }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">Tahun Kelulusan</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col">{{ $participant->tahun_kelulusan }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">Nilai UAN</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col">{{ $participant->nilai_uan }}</div>
                                                </div>
                                                <hr class="mt-5 mb-5">
                                                <div class="mb-2">
                                                    <b>Data Nilai</b>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">Nilai Jasmani</div>
                                                    <div class="col-1">:</div>
                                                    @if ($participant->nilai_jas == null)
                                                        <div class="col">-</div>
                                                    @else
                                                        <div class="col">{{ $participant->nilai_jas }}</div>
                                                    @endif
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">Status Jasmani</div>
                                                    <div class="col-1">:</div>
                                                    @if ($participant->status_jas == null)
                                                        <div class="col">-</div>
                                                    @else
                                                        <div class="col">{{ $participant->status_jas }}</div>
                                                    @endif
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">Keterangan Jasmani</div>
                                                    <div class="col-1">:</div>
                                                    @if ($participant->keterangan_jas == null)
                                                        <div class="col">-</div>
                                                    @else
                                                        <div class="col">{{ $participant->keterangan_jas }}</div>
                                                    @endif
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">Nilai Kesehatan</div>
                                                    <div class="col-1">:</div>
                                                    @if ($participant->nilai_kes == null)
                                                        <div class="col">-</div>
                                                    @else
                                                        <div class="col">{{ $participant->nilai_kes }}</div>
                                                    @endif
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">Status Kesehatan</div>
                                                    <div class="col-1">:</div>
                                                    @if ($participant->status_kes == null)
                                                        <div class="col">-</div>
                                                    @else
                                                        <div class="col">{{ $participant->status_kes }}</div>
                                                    @endif
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">Keterangan Kesehatan</div>
                                                    <div class="col-1">:</div>
                                                    @if ($participant->keterangan_kes == null)
                                                        <div class="col">-</div>
                                                    @else
                                                        <div class="col">{{ $participant->keterangan_kes }}</div>
                                                    @endif
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">Nilai Administrasi</div>
                                                    <div class="col-1">:</div>
                                                    @if ($participant->nilai_min == null)
                                                        <div class="col">-</div>
                                                    @else
                                                        <div class="col">{{ $participant->nilai_min }}</div>
                                                    @endif
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">Status Administrasi</div>
                                                    <div class="col-1">:</div>
                                                    @if ($participant->status_min == null)
                                                        <div class="col">-</div>
                                                    @else
                                                        <div class="col">{{ $participant->status_min }}</div>
                                                    @endif
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">Keterangan Administrasi</div>
                                                    <div class="col-1">:</div>
                                                    @if ($participant->keterangan_min == null)
                                                        <div class="col">-</div>
                                                    @else
                                                        <div class="col">{{ $participant->keterangan_min }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <hr class="mt-5 mb-5">
                                            <div class="mb-2">
                                                <b>Status Kelulusan</b>
                                            </div>
                                            <div class="row text-center">
                                                <div class="col">
                                                    <select class="form-control" name="status_kelulusan" id=""
                                                        required>
                                                        <option value="">=== Pilih Kelulusan ===</option>
                                                        <option value="tidak_lulus">Tidak Lulus</option>
                                                        <option value="lulus">Lulus</option>
                                                    </select>
                                                    @php
                                                        $isGraduate = true;

                                                        if ($participant->nilai_jas == 'TL' || $participant->nilai_kes == 4 || $participant->nilai_min == 'TMS') {
                                                            $isGraduate = false;
                                                        }
                                                    @endphp
                                                    <small class="form-text text-muted">Rekomendasi Kelulusan: @if ($isGraduate)
                                                            <span class="badge badge-success">LULUS</span>
                                                        @else
                                                            <span class="badge badge-danger">TIDAK LULUS</span>
                                                        @endif
                                                    </small>
                                                </div>
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
                    @endforeach
                    <div id="styleSelector"> </div>
                </div>
            </div>
        </div>
    </div>
@endsection
