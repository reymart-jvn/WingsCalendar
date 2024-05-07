<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/shuttlewiseicon.ico') }}">
    <title>{{ config('app.name') }}</title>
    <!-- plugins:css -->

    {{-- customs css --}}
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/vendors/feather/feather.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/typicons/typicons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}" rel="stylesheet"
        type="text/css" />

    <link href="{{ asset('assets/vendors/dropify/dropify.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/vendors/lightgallery/css/lightgallery.css') }}" rel="stylesheet" type="text/css" />

    <!-- endinject -->
    <!-- Plugin css for this page -->
    {{-- <link href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}" rel="stylesheet"
        type="text/css" /> --}}
    {{-- <link href="{{ asset('assets/js/select.dataTables.min.css') }}" rel="stylesheet" type="text/css" /> --}}
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link href="{{ asset('assets/css/vertical-layout-light/style.css') }}" rel="stylesheet" type="text/css" />
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.png" />

    <link href="{{ asset('assets/plugins/datatable/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link href="{{ asset('assets/css/loader/process-loader.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/formvalidation/0.6.2-dev/css/formValidation.min.css"
        integrity="sha512-B9GRVQaYJ7aMZO3WC2UvS9xds1D+gWQoNiXiZYRlqIVszL073pHXi0pxWxVycBk0fnacKIE3UHuWfSeETDCe7w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.16/sweetalert2.min.css"
        integrity="sha512-NvuRGlPf6cHpxQqBGnPe7fPoACpyrjhlSNeXVUY7BZAj1nNhuNpRBq3osC4yr2vswUEuHq2HtCsY2vfLNCndYA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

        <link rel="stylesheet" type="text/css" href="https://printjs-4de6.kxcdn.com/print.min.css">

        <link href="https://api.mapbox.com/mapbox-gl-js/v2.12.0/mapbox-gl.css" rel="stylesheet">
        <script src="https://api.mapbox.com/mapbox-gl-js/v2.12.0/mapbox-gl.js"></script>

        {{-- @vite(['resources/js/app.js']); --}}
    @yield('style')
    <script src="{{ asset('assets/js/loader/process-loader.js') }}" type="text/javascript"></script>
    {{-- <script src="{{ resource_path('js/loader/') }}" type="text/javascript"></script> --}}
    
    <script>
        const processObject = new ProcessLoader();
        //const customSwalObject = new sweetAllertIndicator();
    </script>
    <style>
        .navbar .navbar-brand-wrapper .navbar-brand img {
            height: 120px !important;
        }

        .swal2-modal .swal2-icon,
        .swal2-modal .swal2-success-ring {
            margin-top: 15px !important;
        }

        /* <div class="swal2-icon swal2-success swal2-icon-show" style="display: flex;"><div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div>
  <span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span>
  <div class="swal2-success-ring"></div> <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div>
  <div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div>
</div> */

        .swal2-success-ring {
            margin-top: 30px !important;
        }

        .swal2-success-line-tip {
            margin-top: 10px !important;
        }

        .swal2-success-line-long {
            margin-top: 10px !important;
        }

        .header-title{
            margin-bottom: -0.1rem !important;
        }
    </style>

    
    @yield('css')
</head>

<body class="sidebar-dark">

    <!-- partial:partials/_navbar.html -->
    @include('layouts.star-admin-navbar')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_settings-panel.html -->
        @include('layouts.star-admin-settings')
        <!-- partial -->

        <!-- partial:partials/_sidebar.html -->
        @include('layouts.star-admin-sidebar')
        <!-- partial -->

        <div class="main-panel">
            @yield('content')
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            @include('layouts.star-admin-footer')
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
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
    <script src="{{ asset('assets/vendors/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/dropify/dropify.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>
    <script src="{{ asset('assets/js/dropify.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>

    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ asset('assets/js/jquery.cookie.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>
    <script src="{{ asset('assets/js/Chart.roundedBarCharts.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/select2.js') }}"></script> --}}
    <!-- End custom js for this page-->
    <script src="{{ asset('assets/plugins/datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/chart.js') }}"></script>
    {{-- <script src="{{ asset('assets/plugins/datatable/data-table.js') }}"></script> --}}
    {{-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script> --}}
    <script type="text/javascript" charset="utf8"
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/formvalidation/0.6.2-dev/js/formValidation.min.js"
        integrity="sha512-DlXWqMPKer3hZZMFub5hMTfj9aMQTNDrf0P21WESBefJSwvJguz97HB007VuOEecCApSMf5SY7A7LkQwfGyVfg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- JQUERY VALIDATE-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
        integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"
        integrity="sha512-6S5LYNn3ZJCIm0f9L6BCerqFlQ4f5MwNKq+EthDXabtaJvg3TuFLhpno9pcm+5Ynm6jdA9xfpQoMz2fcjVMk9g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.16/sweetalert2.min.js"
        integrity="sha512-4aFcnPgoxsyUPgn8gNinplVIEoeBizjYPTpmOaUbC3VZQCsRnduAOch9v0Pn30yTeoWq1rIZByAE4/Gg79VPEA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- JQUERY VALIDATE-->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
     <script type="text/javascript" charset="utf8" src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
     <script type="text/javascript" charset="utf8" src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
     <script type="text/javascript" charset="utf8" src="http://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
     {{-- <script type="text/javascript" charset="utf8" src="https://cdn.jsdelivr.net/npm/qrcode-generator/qrcode.min.js"></script> --}}
     {{-- <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.4/qrcode.min.js"></script> --}}
     <script src="{{ asset('assets/js/qrcode.min.js') }}"></script>
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
    <script>
         const changePassword = () => {
            
        }
    </script>

</body>

</html>
