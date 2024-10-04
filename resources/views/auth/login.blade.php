<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/wings.ico') }}">
    <title>{{ config('app.name') }}</title>
    <!-- plugins:css -->
    <link href="{{ asset('assets/vendors/feather/feather.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/typicons/typicons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}" rel="stylesheet" type="text/css" />
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/js/select.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link href="{{ asset('assets/css/vertical-layout-light/style.css') }}" rel="stylesheet" type="text/css" />
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.png" />

    <link href="{{ asset('assets/css/loader/process-loader.css') }}" rel="stylesheet" type="text/css" />
    @yield('style')
    <script src="{{ asset('assets/js/loader/process-loader.js') }}" type="text/javascript"></script>
    <script>
        const processObject = new ProcessLoader();
        //const customSwalObject = new sweetAllertIndicator();
    </script>
    <style>
        .navbar .navbar-brand-wrapper .navbar-brand img {
            height: 120px !important;
        }

        .auth .brand-logo img {
            width: 122px !important;
        }

        .alert {
            margin-bottom: -1rem !important;
        }

        .content-wrapper {
            background-image: rgb(85, 34, 195) !important;
            background-image: linear-gradient(0deg, rgba(85, 34, 195, 1) 0%, rgba(251, 216, 255, 1) 100%) !important;
        }
    </style>
</head>

<body>

    <div class="container-scroller">
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5" style="border-radius: 10px;">
                            <div class="brand-logo">
                                {{-- <img src="../../images/logo.svg" alt="logo"> --}}
                                <center><img style="width: 150px !important"
                                        src="{{ asset('assets/images/logos/wings.png') }}" alt="logo" /></center>
                            </div>
                            <center>
                                <h4>開始</h4>
                                <h6 class="fw-light">サインインの継続</h6>
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </center>
                            <form class="pt-3" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group" style="margin-bottom: 0px;">
                                    <label for="email" value="{{ __('Email') }}"></label>
                                    <input id="email" type="email" name="email" :value="old('email')" required
                                        autofocus class="form-control form-control-lg" placeholder="ユーザーネーム">
                                </div>
                                <div class="form-group" style="margin-bottom: 0px;">
                                    <label for="password" value="{{ __('Password') }}"></label>
                                    <input id="password" type="password" name="password" required
                                        autocomplete="current-password" class="form-control form-control-lg"
                                        placeholder="パスワード">
                                </div>
                                <div class="mt-3 text-center">
                                    <button
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn w-100">
                                        {{ __('サインイン') }}</button>
                                </div>
                                <div class="text-center mt-4 fw-light">
                                  アカウントをお持ちでない場合は、 <a href="{{ url('register') }}" class="text-primary">サインアップ</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!--begin::Process Loader-->
    <div id="save-loader" style="display:none;">
        <div id="fakeloader-overlay-save" class="visible incoming">
            <div class="loader-wrapper-outer-save">
                <div class="loader-wrapper-inner-save">
                    <img height="110px" src="{{ asset('assets/images/image-loader/loader.gif') }}">
                </div>
            </div>
        </div>
    </div>

    <div id="fakeloader-overlay" class="visible incoming">
        <div class="loader-wrapper-outer">
            <div class="loader-wrapper-inner">
                <img height="110px" src="{{ asset('assets/images/image-loader/loader.gif') }}">
            </div>
        </div>
    </div>
    <!--end::Process Loader-->

    <!-- plugins:js -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>

    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ asset('assets/js/jquery.cookie.js') }}"></script>
    <script src="{{ asset('assets/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>
    <script src="{{ asset('assets/js/Chart.roundedBarCharts.js') }}"></script>
    <!-- End custom js for this page-->
    @yield('js')
    <script>
        $(window).on('load', function() {
            setTimeout(function() {
                $("#fakeloader-overlay").fadeOut(300, function() {
                    $("#fakeloader-overlay").remove();
                });
            }, 100);
        });
    </script>
</body>

</html>
