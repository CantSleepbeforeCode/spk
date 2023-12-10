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
                            <h5 class="m-b-10">Peserta</h5>
                            <p class="m-b-0">Daftar Seluruh Calon Peserta TNI AD</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/admin/beranda"> <i class="fa fa-home"></i> </a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Lihat Peserta</a>
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
                                                <th>Status Kelulusan</th>
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
                                                    @if ($participant->status_kelulusan == null)
                                                        <td>TERDAFTAR</td>
                                                    @elseif($participant->status_kelulusan == 'lulus')
                                                        <td>LULUS</td>
                                                    @elseif($participant->status_kelulusan == 'tidak_lulus')
                                                        <td>TIDAK LULUS</td>
                                                    @endif
                                                    <td>
                                                        <button class="btn btn-sm ml-2 mb-2 btn-primary" data-toggle="modal"
                                                            data-target="#detailModal{{ $participant->id }}">Detail</button>
                                                        @if ($participant->status_kelulusan == null)
                                                            <button class="btn btn-sm ml-2 mb-2 btn-success"
                                                                data-toggle="modal"
                                                                data-target="#gradeModal{{ $participant->id }}">Penilaian</button>
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
                    <!-- Page-body end -->
                    @foreach ($participants as $participant)
                        <div class="modal fade" id="detailModal{{ $participant->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="detailModal{{ $participant->id }}Label" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailModal{{ $participant->id }}Label">Data
                                            <b>{{ $participant->nama_lengkap }}</b>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
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
                                        <hr class="mt-5 mb-5">
                                        <div class="mb-2">
                                            <b>Status Kelulusan</b>
                                        </div>
                                        <div class="row text-center">
                                            <div class="col">
                                                @if ($participant->status_kelulusan == null)
                                                    <div class="alert alert-primary" role="alert">
                                                        TERDAFTAR
                                                    </div>
                                                @elseif ($participant->status_kelulusan == 'lulus')
                                                    <div class="alert alert-success" role="alert">
                                                        LULUS
                                                    </div>
                                                @elseif ($participant->status_kelulusan == 'tidak_lulus')
                                                    <div class="alert alert-danger" role="alert">
                                                        TIDAK LULUS
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="gradeModal{{ $participant->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="gradeModal{{ $participant->id }}Label" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="gradeModal{{ $participant->id }}Label">Penilaian
                                            <b>{{ $participant->nama_lengkap }}</b>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="/admin/beri-nilai" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $participant->id }}">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="mb-2">
                                                        <b>Jasmani</b>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Nilai</label>
                                                        <select class="form-control" name="nilai_jas" id=""
                                                            required>
                                                            <option value="">=== Pilih Nilai ===</option>
                                                            <option value="TL"
                                                                @if ($participant->nilai_jas == 'TL') selected @endif>Tidak
                                                                Lulus</option>
                                                            <option value="L"
                                                                @if ($participant->nilai_jas == 'L') selected @endif>Lulus
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Keterangan</label>
                                                        <input type="text" value="{{$participant->keterangan_jas}}" class="form-control" name="keterangan_jas"
                                                            placeholder="Keterangan">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="mb-2">
                                                        <b>Kesehatan</b>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Nilai</label>
                                                        <select class="form-control" name="nilai_kes" id=""
                                                            required>
                                                            <option value="">=== Pilih Nilai ===</option>
                                                            <option value="4"
                                                                @if ($participant->nilai_kes == '4') selected @endif>
                                                                STAKES 4</option>
                                                            <option value="3"
                                                                @if ($participant->nilai_kes == '3') selected @endif>
                                                                STAKES 3</option>
                                                            <option value="2"
                                                                @if ($participant->nilai_kes == '2') selected @endif>
                                                                STAKES 2</option>
                                                            <option value="1"
                                                                @if ($participant->nilai_kes == '1') selected @endif>
                                                                STAKES 1</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Keterangan</label>
                                                        <input type="text" value="{{$participant->keterangan_kes}}" class="form-control" name="keterangan_kes"
                                                            placeholder="Keterangan">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="mb-2">
                                                        <b>Administrasi</b>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Nilai</label>
                                                        <select class="form-control" name="nilai_min" id=""
                                                            required>
                                                            <option value="">=== Pilih Nilai ===</option>
                                                            <option value="TMS"
                                                                @if ($participant->nilai_min == 'TMS') selected @endif>Tidak
                                                                Memenuhi Syarat</option>
                                                            <option value="MS"
                                                                @if ($participant->nilai_min == 'MS') selected @endif>
                                                                Memenuhi Syarat</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Keterangan</label>
                                                        <input type="text" value="{{$participant->keterangan_min}}" class="form-control" name="keterangan_min"
                                                            placeholder="Keterangan">
                                                    </div>
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
    @endsection
