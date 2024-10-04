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
                                        氏名
                                    </th>
                                    <th>
                                        メールアドレス
                                    </th>
                                    <th>
                                        ステータス
                                    </th>
                                    <th style="width: 200px;">
                                        アクション
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
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Account Details</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
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
                "sSearch": "氏名検索:"
            },
            "ajax": {
                "url": '{{ route('get-all-restoring-account') }}',
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
                    "data": "email"
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

    


        //DELETE EVENT
        const restoreAccount = (id) => {
            Swal.fire({
                title: 'アカウントの初期化?',
                icon: 'warning',
                text: "元に戻すことはできません",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: "キャンセル",   
                confirmButtonText: 'Yes, Restore it!'
            }).then((result) => {
                if (result.value) {
                    //process loader true
                    $.ajax({
                        url: "/restore-account/" + id,
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
                                    title: "予期しないエラーが発生いたしました。",
                                    icon: 'error',
                                    html: "<b>" + data
                                        .messages +
                                        "! <br>もしくは管理業者までお問い合わせお願い致します。</b>",
                                    type: "error",
                                });
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            swal.fire({
                                title: "予期しないエラーが発生いたしました。",
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

@endsection
