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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
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

        /* Targeting the select2 dropdown */
        .select2-container--default .select2-selection--multiple .select2-selection__rendered {

            padding: 10px 10px 10px 10px !important;
            /* Adjust font size for selected items */
        }

        .select2-selection__choice {
            font-size: 16px !important;
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
                            <center>
                                {{-- <div class="brand-logo">
                                    <img style="width: 100px !important"
                                        src="{{ asset('assets/images/logos/wings.png') }}" alt="logo" />
                                </div> --}}
                                <h4>登録する</h4>
                                <h6 class="fw-light">登録してスケジュールを確認してみましょう</h6>
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

                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="form-group" style="margin-bottom: 0px;">
                                    <label for="question"></label>
                                    <select id="question" name="question" required
                                        class="form-control form-control-lg">
                                        <option value="" disabled selected>&nbsp &nbsp &nbsp パスコードはありますか?
                                        </option>
                                        <option value="1">&nbsp &nbsp &nbsp YES</option>
                                        <option value="0">&nbsp &nbsp &nbsp NO</option>
                                    </select>
                                </div>
                                <div class="form-group" style="margin-bottom: 0px;" id="passcode_container">
                                    <label for="email"></label>
                                    <input id="passcode" type="text" name="passcode" required autofocus
                                        class="form-control form-control-lg" placeholder="パスコード">
                                </div>
                                <div class="form-group" style="margin-bottom: 0px;">
                                    <label for="email"></label>
                                    <input id="fullname" type="text" name="fullname" required autofocus
                                        class="form-control form-control-lg" placeholder="フルネーム">
                                </div>
                                {{-- <div class="form-group" style="margin-bottom: 0px;">
                                    <label for="availability"></label>
                                    <select id="availability" name="availability" required
                                        class="form-control form-control-lg">
                                        <option value="" disabled selected>&nbsp &nbsp &nbsp 可用性</option>
                                        <option value="平日">&nbsp &nbsp &nbsp 平日</option>
                                        <option value="週末">&nbsp &nbsp &nbsp 週末</option>
                                        <option value="全て">&nbsp &nbsp &nbsp 全て</option>
                                    </select>
                                </div> --}}

                                {{-- <div class="form-group" style="margin-bottom: 0px;">
                                    <select id="availability" name="availability" required multiple
                                        class="form-control form-control-lg">
                                        <option value="monday">&nbsp &nbsp &nbsp Monday</option>
                                        <option value="tuesday">&nbsp &nbsp &nbsp Tuesday</option>
                                        <option value="wednesday">&nbsp &nbsp &nbsp Wednesday</option>
                                        <option value="thursday">&nbsp &nbsp &nbsp Thursday</option>
                                        <option value="friday">&nbsp &nbsp &nbsp Friday</option>
                                        <option value="saturday">&nbsp &nbsp &nbsp Saturday</option>
                                        <option value="sunday">&nbsp &nbsp &nbsp Sunday</option>
                                    </select>
                                </div> --}}

                                <div class="form-group" style="margin-bottom: 0px;">
                                    <label for="question"></label>
                                    <select class="select2-hidden-accessible" id="availability" name="availability[]"
                                        multiple="" tabindex="-1" aria-hidden="true">
                                        <option value="月曜日">月曜日</option>
                                        <option value="火曜日">火曜日</option>
                                        <option value="水曜日">水曜日</option>
                                        <option value="木曜日">木曜日</option>
                                        <option value="金曜日">金曜日</option>
                                        <option value="土曜日">土曜日</option>
                                        <option value="日曜日">日曜日</option>
                                    </select>
                                </div>


                                <div class="form-group" style="margin-bottom: 0px;" id="groupname_container">
                                    <label for="email"></label>
                                    <input id="groupname" type="text" name="groupname"
                                        class="form-control form-control-lg" placeholder="Group Name">
                                </div>
                                <div class="form-group" style="margin-bottom: 0px;" id="groupname_acronym_container">
                                    <label for="email"></label>
                                    <input id="groupname_acronym" type="text" name="groupname_acronym"
                                        class="form-control form-control-lg" placeholder="Group Name Acronym">
                                </div>
                                <div class="form-group" style="margin-bottom: 0px;">
                                    <label for="email"></label>
                                    <input id="email" type="email" name="email" required
                                        class="form-control form-control-lg" placeholder="電子メール">
                                </div>
                                <div class="form-group" style="margin-bottom: 0px;">
                                    <label for="new-password"></label>
                                    <x-jet-input id="password"
                                        class="form-control form-control-lg border-none rounded-0 shadow-none"
                                        type="password" name="password" required autocomplete="new-password"
                                        placeholder="パスワード" />
                                </div>
                                <div class="form-group" style="margin-bottom: 0px;">
                                    <label for="confirm-password"></label>
                                    <x-jet-input id="password_confirmation"
                                        class="form-control form-control-lg border-none rounded-0 shadow-none"
                                        type="password" name="password_confirmation" required
                                        autocomplete="new-password" placeholder="パスワードを認証する" />
                                </div>


                                <div class="mt-3 text-center">
                                    <button
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn w-100">
                                        {{ __('提出する') }}</button>
                                </div>
                                <div class="text-center mt-3 fw-light">
                                    すでにアカウントをお持ちですか? <a href="/" class="text-primary">サインイン</a>
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
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <!-- End custom js for this page-->
    @yield('js')
    <script>
        $(function() {
            $('#availability').select2({
                width: '100%',
                placeholder: "空き状況を選択してください",
            });
        });

        $(window).on('load', function() {
            setTimeout(function() {
                $("#fakeloader-overlay").fadeOut(300, function() {
                    $("#fakeloader-overlay").remove();
                });
            }, 100);
        });

        $(document).ready(function() {
            // Initially hide both fields on page load
            $("#groupname_container").hide();
            $("#groupname_acronym_container").hide();
            $("#passcode_container").hide();

        });

        $("#question").change(function() {
            // $("#department").prop('disabled', false);
            // $("#department").empty();
            // $("#position").prop('disabled', false);
            // $("#position").empty();

            if ($("#question").val() == "1") {
                $("#passcode").prop('disabled', false);
                $("#groupname_container").hide();
                $("#groupname_acronym_container").hide();
                $("#passcode_container").show();

                $("#groupname").val("-");
                $("#groupname_acronym").val("-");

                $("#groupname").text("-");
                $("#groupname_acronym").text("-");
                $("#passcode").val("");
            } else {
                $("#passcode").prop('disabled', true);
                $("#passcode_container").hide();

                $("#groupname").val("");
                $("#groupname_acronym").val("");

                $("#groupname_container").show();
                $("#groupname_acronym_container").show();
            }


        });
    </script>
</body>

</html>
