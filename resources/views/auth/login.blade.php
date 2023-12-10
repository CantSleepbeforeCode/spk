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
    <link rel="stylesheet" href="/auth/modules/bootstrap-social/bootstrap-social.css">

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
                        class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="login-brand">
                            <img src="/auth/img/stisla-fill.svg" alt="logo" width="100"
                                class="shadow-light rounded-circle">
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Masuk</h4>
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

                                <form method="POST" action="#" class="needs-validation" novalidate="">
                                    @csrf
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" class="form-control" name="username" tabindex="1"
                                            required autofocus>
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label class="control-label">Password</label>
                                        </div>
                                        <input type="password" class="form-control" name="password" tabindex="2"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Masuk
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

    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="/auth/js/scripts.js"></script>
    <script src="/auth/js/custom.js"></script>
</body>

</html>
