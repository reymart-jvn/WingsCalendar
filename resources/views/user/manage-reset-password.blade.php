@extends('layouts.star-admin-app')
@section('css')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $table_title }}</h4>
                    <p class="card-description">
                        {{ $label }}
                    <div class="table-responsive pt-3">
                        <table class="table table-hover" id="table_id">
                            <thead>
                                <tr>
                                    <th>
                                        Full Name
                                    </th>
                                    <th>
                                        Date of Birth
                                    </th>
                                    <th>
                                        Address
                                    </th>
                                    <th>
                                        Email
                                    </th>
                                    <th>
                                        Company
                                    </th>
                                    <th>
                                        Department
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th style="width: 200px;">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal-->
    <div class="modal fade" tabindex="-1" role="dialog" id="view_user_modal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="exampleModalLabel">View Account Details</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="margin:20px">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="symbol symbol-50 symbol-xl-150">
                                    <img style="width: 100%;height:100%" id="show_avatar" />
                                    <i class="symbol-badge symbol-badge-bottom bg-success"></i>
                                </div>


                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="">Full Name:</label>
                                    <b>
                                        <p style="font-weight:bold; font-size:15" id="show_full_name" name="show_full_name">
                                        </p>
                                    </b>
                                </div>
                                <div class="form-group">
                                    <label for="">Email Address:</label>
                                    <p style="font-weight:bold" id="show_email"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Mobile Number:</label>
                                    <p style="font-weight:bold" id="show_contact"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Telephone Number:</label>
                                    <p style="font-weight:bold" id="show_telephone_number"></p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Sex:</label>
                                    <p style="font-weight:bold" id="show_sex"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Address:</label>
                                    <p style="font-weight:bold" id="show_address"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Date of Birth:</label>
                                    <p style="font-weight:bold" id="show_dob"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Barangay:</label>
                                    <p style="font-weight:bold" id="show_barangay"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Civil Status:</label>
                                    <p style="font-weight:bold" id="show_civil_status"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Religion:</label>
                                    <p style="font-weight:bold" id="show_religion"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">City:</label>
                                    <p style="font-weight:bold" id="show_city"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Province:</label>
                                    <p style="font-weight:bold" id="show_province"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Region:</label>
                                    <p style="font-weight:bold" id="show_region"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>


    <!-- Update Modal -->
    <div class="modal fade" id="update_user_modal" tabindex="-1" role="dialog" aria-labelledby="update_user_label"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="update_user_label">Update Vehicle Type</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" id="update_user_forms" method="POST">
                        @csrf
                        @method('POST')
                        <input type="hidden" id="update_id" name="update_id">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="firstname">Fist Name *</label>
                                    <input type="text" class="form-control " id="firstname" name="firstname"
                                        placeholder="First Name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="lastname">Last Name *</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname"
                                        placeholder="Last Name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="middlename">Middle Name *</label>
                                    <input type="text" class="form-control" id="middlename" name="middlename"
                                        placeholder="Middle Name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="suffix">Suffix *</label>
                                    <select class="selectpicker form-control" data-live-search="true" name="suffix"
                                        id="suffix">
                                        <option value="" disabled="" selected="">Select...</option>
                                        <option value="II">II</option>
                                        <option value="III">III</option>
                                        <option value="IV">IV</option>
                                        <option value="V">V</option>
                                        <option value="JR">JR</option>
                                        <option value="SR">SR</option>
                                        <option value="NA">NA</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date_of_birth">Date of Birth *</label>
                                    {{-- <input type="text" class="form-control" id="date_of_birth"/> --}}

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> <span class="mdi mdi-calendar-plus"></span>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="date_of_birth"
                                            name="date_of_birth" placeholder="Date of Birth">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sex">Sex *</label>
                                    <select class="selectpicker form-control" data-live-search="true" name="sex"
                                        id="sex">
                                        <option value="" disabled="" selected="">Select...</option>
                                        <option value="MALE">Male</option>
                                        <option value="FEMALE">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="civil_status">Civil Status *</label>
                                    <select class="selectpicker form-control" data-live-search="true" name="civil_status"
                                        id="civil_status">
                                        <option value="" disabled="" selected="">Select...</option>
                                        <option value="SINGLE">Single</option>
                                        <option value="MARRIED">Married</option>
                                        <option value="DIVORCED">Divorced</option>
                                        <option value="SEPARATED">Separated</option>
                                        <option value="WIDOWED">Widowed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="religion">Religion *</label>
                                    <input type="text" class="form-control" id="religion" name="religion"
                                        placeholder="Religion">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Region *</label>
                                    <select class="form-control" data-live-search="true" id="region" name="region">
                                        <option value="" disabled selected>Select.....</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Province -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Province *</label>
                                    <select class="form-control" data-live-search="true" id="province" name="province">
                                        <option value="" disabled selected>Select.....</option>
                                    </select>
                                </div>
                            </div>

                            <!-- City -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>City *</label>
                                    <select class="form-control" data-live-search="true" id="city" name="city">
                                        <option value="" disabled selected>Select.....</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- Barangay -->
                                <div class="form-group">
                                    <label>Barangay *</label>
                                    <select class="form-control" data-live-search="true" id="barangay" name="barangay">
                                        <option value="" disabled selected>Select.....</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="home_address">Home Adrress *</label><small>(e.g. street, block, lot,
                                            unit)</small>
                                        <textarea class="form-control" placeholder="Home Address" name="home_address" id="home_address"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="contact">Contact *</label>
                                        <input type="text" class="form-control" id="contact" name="contact"
                                            placeholder="Contact Number">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" name="email" :value="old('email')" required
                                        class="form-control" placeholder="user@gmail.com">
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="region">Company *</label>
                                    <select class="selectpicker form-control" id="company_name" name="company_name">
                                        <option value="" disabled selected>Select...</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="region">Department *</label>
                                    <select class="selectpicker form-control" id="deparment" name="department">
                                        <option value="" disabled selected>Select...</option>
                                    </select>
                                </div>
                            </div>


                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/js/ph_address.js') }}"></script>
    <script>
        $(function() {
            $('#date_of_birth').datepicker();

        });
    </script>

    <script>
        //DATA TABLE FOR DRIVERS LIST
        let table = new DataTable('#table_id', {
            "processing": true,
            "serverSide": true,
            "language": {
                "sSearch": "Search Fullname:"
            },
            "ajax": {
                "url": '{{ route('get-all-users-reset') }}',
                "dataType": "json",
                "type": "GET",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columns": [{
                    "data": "fullname"
                },
                {
                    "data": "dob"
                },
                {
                    "data": "address"
                },
                {
                    "data": "email"
                },
                {
                    "data": "company"
                },
                {
                    "data": "department"
                },
                {
                    "data": "status"
                },
                {
                    "data": "actions"
                },
            ],
            "columnDefs": [{
                "orderable": false,
                "targets": [2, 3]
            }, ],
            initComplete: function() {
                $('.dataTables_filter input').unbind();
                $('.dataTables_filter input').bind('keyup', function(e) {
                    var code = e.keyCode || e.which;
                    if (code == 13) {
                        table.search(this.value).draw();
                    }
                });
            },
        });

        //GET VEHICLE TYPE INFO
        const view = (id) => {
            $.ajax({
                url: "/get-users-info-by-id/" + id,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                type: "GET",
                beforeSend: function() {
                    processObject.showProcessLoader();
                },
                success: function(data) {
                    console.log(data[0].persons_info);
                    if (data.success) {
                        $('#view_user_modal')
                            .find('.modal-header > h5')
                            .text("View User Account Details").end()
                            .modal('show');
                        // $('#update_id').val(data.data.id);
                        $('#show_avatar').attr('src', '../assets/images/default-user-image.webp');
                        $('#show_full_name').text(data[0].first_name + " " + data[0]
                            .middle_name + " " + data[0].last_name);
                        $('#show_email').text(data[0].user.email);
                        $('#show_contact').text(data[0].telephone_number);
                        $('#show_sex').text(data[0].gender);
                        $('#show_dob').text(data[0].date_of_birth);
                        $('#show_civil_status').text(data[0].civil_status);
                        $('#show_address').text(data[0].home_address);
                        $('#show_barangay').text(data[0].barangay);
                        $('#show_religion').text(data[0].religion);
                        $('#show_city').text(data[0].city_mun);
                        $('#show_province').text(data[0].province);
                        $('#show_region').text(data[0].region);

                    } else {
                        swal.fire({
                            title: "Oops! Something went wrong.",
                            icon: 'error',
                            html: "<b>" + data
                                .messages +
                                "! <br>An unexpected error seems to have occured. Why not try refreshing your page? Or you can contact us if the problem persists.</b>",
                            type: "error",
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    swal.fire({
                        icon: 'error',
                        title: "Oops! Something went wrong.",
                        text: errorThrown,
                        type: "error",
                    })
                },
                complete: function() {
                    processObject.hideProcessLoader();
                },
            });
        }



        //DELETE EVENT
        const resetPassword = (id) => {
            // const url = '{{ route('get-drivers') }}';
            Swal.fire({
                title: 'Reset Password?',
                icon: 'warning',
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Reset it!'
            }).then((result) => {
                if (result.value) {
                    //process loader true
                    $.ajax({
                        url: "/reset-user-password/" + id,
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        type: "GET",
                        beforeSend: function() {
                            processObject.showProcessLoader();
                        },
                        success: function(data) {
                            if (data.success) {
                                table.ajax.reload(null, false);
                                Swal.fire({
                                    title: "Save!",
                                    text: data.messages,
                                    icon: "success"
                                });
                            } else {
                                Swal.fire({
                                    title: "Oops! something went wrong.",
                                    text: data.messages,
                                    icon: 'success'
                                })
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            swal.fire({
                                title: "Oops! something went wrong.",
                                text: errorThrown,
                                icon: 'success'
                            })
                        },
                        complete: function() {
                            processObject.hideProcessLoader();
                        },
                    });
                }
            })
        };
    </script>

    <script>
        //Start of Function for Address
        let myData = data;
        let region = '';
        let province = '';
        let counter = 1;
        $(document).ready(function() {
            addressAutoFill('#region', '#province', '#city', '#barangay');
            addressAutoFill('#region-2', '#province-2', '#city-2', '#barangay-2');
        });


        function addressAutoFill(selectRegion, selectProvince, selectCity, selectBarangay) {
            var $select = $(selectRegion);
            $.each(myData, function(index, value) {
                $select.append('<option value="' + index + '">' + value.region_name + '</option>');
            });

            $(selectRegion).on('change', function() {
                var selectedRegion = $(this).children("option:selected").val();
                region = selectedRegion;
                var $select = $(selectProvince);
                var $select_city = $(selectCity);
                var $select_brgy = $(selectBarangay);
                $select.empty()
                $select_city.empty()
                $select_brgy.empty()
                $select.append('<option value="" disabled selected>Select.....</option>');
                $select_city.append('<option value="" disabled selected>Select.....</option>');
                $select_brgy.append('<option value="" disabled selected>Select.....</option>');
                $.each(myData[selectedRegion].province_list, function(index, value) {
                    $select.append('<option value="' + index + '">' + index + '</option>');
                });
            });

            $(selectProvince).on('change', function() {
                var selectedProvince = $(this).children("option:selected").val();
                province = selectedProvince;
                var $select = $(selectCity);
                var $select_brgy = $(selectBarangay);
                $select.empty()
                $select_brgy.empty()
                $select.append('<option value="" disabled selected>Select.....</option>');
                $select_brgy.append('<option value="" disabled selected>Select.....</option>');
                $.each(myData[region].province_list[selectedProvince].municipality_list, function(index, value) {
                    $select.append('<option value="' + index + '">' + index + '</option>');
                });
            });

            $(selectCity).on('change', function() {
                var selectedCity = $(this).children("option:selected").val();
                var $select = $(selectBarangay);
                $select.empty()
                $select.append('<option value="" disabled selected>Select.....</option>');
                $.each(myData[region].province_list[province].municipality_list[selectedCity].barangay_list,
                    function(index, value) {
                        $select.append('<option value="' + value + '">' + value + '</option>');
                    });

            });
        }
        //End of Function for Address
    </script>
@endsection
