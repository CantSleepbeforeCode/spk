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
                                <h5>Data Calon Peserta <span class="badge badge-primary" data-toggle="modal"
                                        data-target="#addModal"><i class="fa fa-plus"></i></span></h5>
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
                                                        <button class="btn btn-sm ml-2 mb-2 btn-warning" data-toggle="modal"
                                                            data-target="#editModal{{ $participant->id }}">Ubah</button>
                                                        <button class="btn btn-sm ml-2 mb-2 btn-danger" data-toggle="modal"
                                                            data-target="#deleteModal{{ $participant->id }}">Hapus</button>
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
                    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form action="/admin/tambah-peserta" method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addModalLabel">Tambah Data</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="nama_lengkap">Nama Lengkap</label>
                                                <input id="nama_lengkap" type="text" class="form-control"
                                                    name="nama_lengkap" autofocus required>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                                    <option value="PRIA">PRIA</option>
                                                    <option value="WANITA">WANITA</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="tempat_lahir">Tempat Lahir</label>
                                                <input id="tempat_lahir" type="text" class="form-control"
                                                    name="tempat_lahir" required>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                                <input id="tanggal_lahir" type="date" class="form-control"
                                                    max="<?php echo date('Y-m-d'); ?>" name="tanggal_lahir" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="tinggi_badan">Tinggi Badan</label>
                                                <input id="tinggi_badan" type="number" class="form-control"
                                                    name="tinggi_badan" required>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="berat_badan">Berat Badan</label>
                                                <input id="berat_badan" type="number" class="form-control"
                                                    name="berat_badan" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col">
                                                <label for="alamat">Alamat</label>
                                                <input id="alamat" type="text" class="form-control" name="alamat"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col">
                                                <label for="nomor_telepon">Nomor Telepon</label>
                                                <input id="nomor_telepon" type="text" class="form-control"
                                                    name="nomor_telepon" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="agama">Agama</label>
                                                <select name="agama" id="agama" class="form-control">
                                                    <option value="ISLAM">ISLAM</option>
                                                    <option value="KRISTEN">KRISTEN</option>
                                                    <option value="KATOLIK">KATOLIK</option>
                                                    <option value="HINDU">HINDU</option>
                                                    <option value="BUDDHA">BUDDHA</option>
                                                    <option value="KHONGHUCU">KHONGHUCU</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="suku">Suku</label>
                                                <input id="suku" type="text" class="form-control" name="suku"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="pendidikan">Pendidikan</label>
                                                <select name="pendidikan" id="pendidikan" class="form-control">
                                                    <option value="SMA / MA">SMA / MA</option>
                                                    <option value="SMK">SMK</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="tahun_kelulusan">Tahun Kelulusan</label>
                                                <input id="tahun_kelulusan" type="number" min="1900"
                                                    max="{{ date('Y') }}" step="1" class="form-control"
                                                    name="tahun_kelulusan" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="nama_sekolah">Nama Sekolah</label>
                                                <input id="nama_sekolah" type="text" class="form-control"
                                                    name="nama_sekolah" required>
                                            </div>
                                            <div class="form-group col">
                                                <label for="jurusan_dikum">Jurusan Pendidikan</label>
                                                <input id="jurusan_dikum" type="text" class="form-control"
                                                    name="jurusan_dikum" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col">
                                                <label for="nilai_uan">Nilai UAN</label>
                                                <input id="nilai_uan" type="number" step="0.01" class="form-control"
                                                    name="nilai_uan" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col">
                                                <label for="nilai_uan">Wilayah</label>
                                                <select name="kodim" class="form-control" required>
                                                    <option value="">--- Pilih Wilayah ---</option>
                                                    <option value="Balikpapan">Balikpapan</option>
                                                    <option value="Samarinda">Samarinda</option>
                                                    <option value="Berau">Berau</option>
                                                    <option value="Tanah Grogot">Tanah Grogot</option>
                                                    <option value="Kutai Kartanegara">Kutai Kartanegara</option>
                                                    <option value="Bontang">Bontang</option>
                                                    <option value="Kutai Timur">Kutai Timur</option>
                                                    <option value="Kutai Barat">Kutai Barat</option>
                                                    <option value="Penajam Paser Utara">Penajam Paser Utara</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="nama_ortu">Nama Orang Tua</label>
                                                <input id="nama_ortu" type="text" class="form-control"
                                                    name="nama_ortu" required>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="pekerjaan_ortu">Pekerjaan Orang Tua</label>
                                                <input id="pekerjaan_ortu" type="text" class="form-control"
                                                    name="pekerjaan_ortu" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col">
                                                <label for="alamat_ortu">Alamat Orang Tua</label>
                                                <input id="alamat_ortu" type="text" class="form-control"
                                                    name="alamat_ortu" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col">
                                                <label for="nama_wali">Nama Wali</label>
                                                <input id="nama_wali" type="text" class="form-control"
                                                    name="nama_wali" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col">
                                                <label for="sumber_info">Sumber Informasi</label>
                                                <input id="sumber_info" type="text" class="form-control"
                                                    name="sumber_info" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Tutup</button>
                                        <input type="submit" value="Tambah" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @foreach ($participants as $participant)
                        <div class="modal fade" id="editModal{{ $participant->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="editModal{{ $participant->id }}Label" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <form action="/admin/ubah-peserta" method="POST">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModal{{ $participant->id }}Label">Ubah Data
                                                {{ $participant->nama_lengkap }}</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $participant->id }}">
                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <label for="nama_lengkap">Nama Lengkap</label>
                                                    <input id="nama_lengkap" type="text" class="form-control"
                                                        name="nama_lengkap" value="{{ $participant->nama_lengkap }}"
                                                        autofocus required>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                                        <option value="PRIA"
                                                            @if ($participant->jenis_kelamin == 'PRIA') selected @endif>PRIA</option>
                                                        <option value="WANITA"
                                                            @if ($participant->jenis_kelamin == 'WANITA') selected @endif>WANITA
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <label for="tempat_lahir">Tempat Lahir</label>
                                                    <input id="tempat_lahir" type="text" class="form-control"
                                                        name="tempat_lahir" value="{{ $participant->tempat_lahir }}"
                                                        required>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                                    <input id="tanggal_lahir" type="date" class="form-control"
                                                        max="<?php echo date('Y-m-d'); ?>"
                                                        value="{{ $participant->tanggal_lahir }}" name="tanggal_lahir"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <label for="tinggi_badan">Tinggi Badan</label>
                                                    <input id="tinggi_badan" type="number" class="form-control"
                                                        name="tinggi_badan" value="{{ $participant->tinggi_badan }}"
                                                        required>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="berat_badan">Berat Badan</label>
                                                    <input id="berat_badan" type="number"
                                                        value="{{ $participant->berat_badan }}" class="form-control"
                                                        name="berat_badan" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col">
                                                    <label for="alamat">Alamat</label>
                                                    <input id="alamat" type="text" class="form-control"
                                                        name="alamat" value="{{ $participant->alamat }}" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col">
                                                    <label for="nomor_telepon">Nomor Telepon</label>
                                                    <input id="nomor_telepon" type="text" class="form-control"
                                                        name="nomor_telepon" value="{{ $participant->nomor_telepon }}"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <label for="agama">Agama</label>
                                                    <select name="agama" id="agama" class="form-control">
                                                        <option value="ISLAM"
                                                            @if ($participant->agama == 'ISLAM') selected @endif>ISLAM</option>
                                                        <option value="KRISTEN"
                                                            @if ($participant->agama == 'KRISTEN') selected @endif>KRISTEN
                                                        </option>
                                                        <option value="KATOLIK"
                                                            @if ($participant->agama == 'KATOLIK') selected @endif>KATOLIK
                                                        </option>
                                                        <option value="HINDU"
                                                            @if ($participant->agama == 'HINDU') selected @endif>HINDU
                                                        </option>
                                                        <option value="BUDDHA"
                                                            @if ($participant->agama == 'BUDDHA') selected @endif>BUDDHA
                                                        </option>
                                                        <option value="KHONGHUCU"
                                                            @if ($participant->agama == 'KHONGHUCU') selected @endif>KHONGHUCU
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="suku">Suku</label>
                                                    <input id="suku" type="text" class="form-control"
                                                        name="suku" value="{{ $participant->suku }}" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <label for="pendidikan">Pendidikan</label>
                                                    <select name="pendidikan" id="pendidikan" class="form-control">
                                                        <option value="SMA / MA">SMA / MA</option>
                                                        <option value="SMK">SMK</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="tahun_kelulusan">Tahun Kelulusan</label>
                                                    <input id="tahun_kelulusan" type="number" min="1900"
                                                        max="{{ date('Y') }}" step="1" class="form-control"
                                                        name="tahun_kelulusan"
                                                        value="{{ $participant->tahun_kelulusan }}" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <label for="nama_sekolah">Nama Sekolah</label>
                                                    <input id="nama_sekolah" type="text" class="form-control"
                                                        name="nama_sekolah" value="{{ $participant->nama_sekolah }}"
                                                        required>
                                                </div>
                                                <div class="form-group col">
                                                    <label for="jurusan_dikum">Jurusan Pendidikan</label>
                                                    <input id="jurusan_dikum" type="text" class="form-control"
                                                        name="jurusan_dikum" value="{{ $participant->jurusan_dikum }}"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col">
                                                    <label for="nilai_uan">Nilai UAN</label>
                                                    <input id="nilai_uan" type="number" step="0.01"
                                                        class="form-control" value="{{ $participant->nilai_uan }}"
                                                        name="nilai_uan" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col">
                                                    <label for="nilai_uan">Wilayah</label>
                                                    <select name="kodim" class="form-control" required>
                                                        <option value="Balikpapan"
                                                            @if ($participant->kodim == 'Balikpapan') selected @endif>Balikpapan
                                                        </option>
                                                        <option value="Samarinda"
                                                            @if ($participant->kodim == 'Samarinda') selected @endif>Samarinda
                                                        </option>
                                                        <option value="Berau"
                                                            @if ($participant->kodim == 'Berau') selected @endif>Berau
                                                        </option>
                                                        <option value="Tanah Grogot"
                                                            @if ($participant->kodim == 'Tanah Grogot') selected @endif>Tanah Grogot
                                                        </option>
                                                        <option value="Kutai Kartanegara"
                                                            @if ($participant->kodim == 'Kutai Kartanegara') selected @endif>Kutai
                                                            Kartanegara</option>
                                                        <option value="Bontang"
                                                            @if ($participant->kodim == 'Bontang') selected @endif>Bontang
                                                        </option>
                                                        <option value="Kutai Timur"
                                                            @if ($participant->kodim == 'Kutai Timur') selected @endif>Kutai Timur
                                                        </option>
                                                        <option value="Kutai Barat"
                                                            @if ($participant->kodim == 'Kutai Barat') selected @endif>Kutai Barat
                                                        </option>
                                                        <option value="Penajam Paser Utara"
                                                            @if ($participant->kodim == 'Penajam Paser Utara') selected @endif>Penajam
                                                            Paser Utara</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <label for="nama_ortu">Nama Orang Tua</label>
                                                    <input id="nama_ortu" type="text" class="form-control"
                                                        name="nama_ortu" value="{{ $participant->nama_ortu }}" required>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="pekerjaan_ortu">Pekerjaan Orang Tua</label>
                                                    <input id="pekerjaan_ortu" type="text" class="form-control"
                                                        name="pekerjaan_ortu" value="{{ $participant->pekerjaan_ortu }}"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col">
                                                    <label for="alamat_ortu">Alamat Orang Tua</label>
                                                    <input id="alamat_ortu" type="text" class="form-control"
                                                        name="alamat_ortu" value="{{ $participant->alamat_ortu }}"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col">
                                                    <label for="nama_wali">Nama Wali</label>
                                                    <input id="nama_wali" type="text" class="form-control"
                                                        name="nama_wali" value="{{ $participant->nama_wali }}" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col">
                                                    <label for="sumber_info">Sumber Informasi</label>
                                                    <input id="sumber_info" type="text" class="form-control"
                                                        name="sumber_info" value="{{ $participant->sumber_info }}"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Tutup</button>
                                            <input type="submit" value="Ubah" class="btn btn-warning">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="deleteModal{{ $participant->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="deleteModal{{ $participant->id }}Label" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModal{{ $participant->id }}Label">Hapus Data
                                            {{ $participant->nama_lengkap }}?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Anda yakin ingin menghapus data dari {{ $participant->nama_lengkap }}? Setelah
                                        dihapus data tidak dapat dikembalikan.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Tutup</button>
                                        <a href="/admin/hapus-peserta/{{ $participant->id }}"
                                            class="btn btn-danger">Hapus</a>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                            @if ($participant->penilaian->bobot_jas == null)
                                                <div class="col">-</div>
                                            @else
                                                <div class="col">{{ $participant->penilaian->bobot_jas->sub_kategori }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-4">Status Jasmani</div>
                                            <div class="col-1">:</div>
                                            @if ($participant->penilaian->bobot_jas == null)
                                                <div class="col">-</div>
                                            @else
                                                <div class="col">{{ $participant->penilaian->bobot_jas->deskripsi }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-4">Keterangan Jasmani</div>
                                            <div class="col-1">:</div>
                                            @if ($participant->penilaian->keterangan_jas == null)
                                                <div class="col">-</div>
                                            @else
                                                <div class="col">{{ $participant->penilaian->keterangan_jas }}</div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-4">Nilai Kesehatan</div>
                                            <div class="col-1">:</div>
                                            @if ($participant->penilaian->bobot_kes == null)
                                                <div class="col">-</div>
                                            @else
                                                <div class="col">{{ $participant->penilaian->bobot_kes->sub_kategori }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-4">Status Kesehatan</div>
                                            <div class="col-1">:</div>
                                            @if ($participant->penilaian->bobot_kes == null)
                                                <div class="col">-</div>
                                            @else
                                                <div class="col">{{ $participant->penilaian->bobot_kes->deskripsi }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-4">Keterangan Kesehatan</div>
                                            <div class="col-1">:</div>
                                            @if ($participant->penilaian->keterangan_kes == null)
                                                <div class="col">-</div>
                                            @else
                                                <div class="col">{{ $participant->penilaian->keterangan_kes }}</div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-4">Nilai Administrasi</div>
                                            <div class="col-1">:</div>
                                            @if ($participant->penilaian->bobot_min == null)
                                                <div class="col">-</div>
                                            @else
                                                <div class="col">{{ $participant->penilaian->bobot_min->sub_kategori }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-4">Status Administrasi</div>
                                            <div class="col-1">:</div>
                                            @if ($participant->penilaian->bobot_min == null)
                                                <div class="col">-</div>
                                            @else
                                                <div class="col">{{ $participant->penilaian->bobot_min->deskripsi }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-4">Keterangan Administrasi</div>
                                            <div class="col-1">:</div>
                                            @if ($participant->penilaian->keterangan_min == null)
                                                <div class="col">-</div>
                                            @else
                                                <div class="col">{{ $participant->penilaian->keterangan_min }}</div>
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
                                                            @foreach ($bobots as $bobot)
                                                                @if ($bobot->kategori == 'jas')
                                                                    @if ($participant->penilaian->nilai_jas == $bobot->bobot_id)
                                                                        <option value="{{ $bobot->bobot_id }}" selected>
                                                                            {{ $bobot->deskripsi }}</option>
                                                                    @else
                                                                        <option value="{{ $bobot->bobot_id }}">
                                                                            {{ $bobot->deskripsi }}</option>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Keterangan</label>
                                                        <input type="text"
                                                            value="{{ $participant->penilaian->keterangan_jas }}"
                                                            class="form-control" name="keterangan_jas"
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
                                                            @foreach ($bobots as $bobot)
                                                                @if ($bobot->kategori == 'kes')
                                                                    @if ($participant->penilaian->nilai_kes == $bobot->bobot_id)
                                                                        <option value="{{ $bobot->bobot_id }}" selected>
                                                                            {{ $bobot->deskripsi }}</option>
                                                                    @else
                                                                        <option value="{{ $bobot->bobot_id }}">
                                                                            {{ $bobot->deskripsi }}</option>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Keterangan</label>
                                                        <input type="text"
                                                            value="{{ $participant->penilaian->keterangan_kes }}"
                                                            class="form-control" name="keterangan_kes"
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
                                                            @foreach ($bobots as $bobot)
                                                                @if ($bobot->kategori == 'min')
                                                                    @if ($participant->penilaian->nilai_min == $bobot->bobot_id)
                                                                        <option value="{{ $bobot->bobot_id }}" selected>
                                                                            {{ $bobot->deskripsi }}</option>
                                                                    @else
                                                                        <option value="{{ $bobot->bobot_id }}">
                                                                            {{ $bobot->deskripsi }}</option>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Keterangan</label>
                                                        <input type="text" value="{{ $participant->keterangan_min }}"
                                                            class="form-control" name="keterangan_min"
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
