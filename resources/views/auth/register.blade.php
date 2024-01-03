<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>SPK</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="/auth/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/auth/modules/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="/auth/modules/jquery-selectric/selectric.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="/auth/css/style.css">
    <link rel="stylesheet" href="/auth/css/components.css">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div
                        class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                        <div class="login-brand">
                            <h1 class="fw-bold">SPK-TNI</h1>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Daftar</h4>
                            </div>

                            <div class="card-body">

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

                                <form method="POST" action="/register">
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
                                                <option value="">--- Pilih Satuan Wilayah ---</option>
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

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            Daftar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="/auth/modules/jquery.min.js"></script>
    <script src="/auth/modules/popper.js"></script>
    <script src="/auth/modules/tooltip.js"></script>
    <script src="/auth/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="/auth/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="/auth/modules/moment.min.js"></script>
    <script src="/auth/js/stisla.js"></script>

    <!-- JS Libraies -->
    <script src="/auth/modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
    <script src="/auth/modules/jquery-selectric/jquery.selectric.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="/auth/js/page/auth-register.js"></script>

    <!-- Template JS File -->
    <script src="/auth/js/scripts.js"></script>
    <script src="/auth/js/custom.js"></script>
</body>

</html>
