<!DOCTYPE html>
<html lang="en">


<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/shuttlewiseicon.ico') }}">
    <title>Wings Calendar</title>
    <!-- plugins:css -->
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
    <link href="{{ asset('assets/js/select.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link href="{{ asset('assets/css/vertical-layout-light/style.css') }}" rel="stylesheet" type="text/css" />
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.png" />

    <link href="{{ asset('assets/css/loader/process-loader.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    @yield('style')
    <script src="{{ asset('assets/js/loader/process-loader.js') }}" type="text/javascript"></script>
    <script>
        const processObject = new ProcessLoader();
        //const customSwalObject = new sweetAllertIndicator();
    </script>
 
</head>

<body>

    <div class="container-scroller">
        <!-- partial:partials/_horizontal-navbar.html -->
        @include('landing_page.menu')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
         
            @yield('content')
          </div>
      </div>
      @include('landing_page.footer')
      <!-- container-scroller -->
    <!--begin::Process Loader-->


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