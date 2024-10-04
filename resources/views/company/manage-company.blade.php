@extends('layouts.star-admin-app')
@section('css')
    <style>
        td.details-control {
            background: url('../assets/images/plus.png') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url('../assets/images/minus.png') no-repeat center center;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-flex justify-content-between align-items-center">{{ $table_title }}
                        {{-- <button type="button" data-toggle="modal" data-target="#update_modal" class="btn btn-success btn-icon-tex">Add New company Type</button> --}}
                        @if (Gate::allows('permission', 'createCompany'))
                            <button type="button" onclick="showModalAdd()"
                                class="btn btn-success btn-icon-tex">新しい会社を追加</button>
                        @endif
                    </h4>

                    <p class="card-description">
                        {{ $label }}
                    </p>
                    <div class="table-responsive pt-3">
                        <table class="table" id="table_id">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>
                                        コード
                                    </th>
                                    <th>
                                        会社名
                                    </th>
                                    <th>

                                        電子メール
                                    </th>
                                    <th>
                                        住所
                                    </th>
                                    <th>

                                        連絡先番号
                                    </th>
                                    <th>
                                        電話番号
                                    </th>
                                    <th>
                                        状態
                                    </th>
                                    <th @if (Gate::allows('permission', 'updateCompany') || Gate::allows('permission', 'deleteCompany')) style="width: 200px;" @endif>
                                        @if (Gate::allows('permission', 'updateCompany') || Gate::allows('permission', 'deleteCompany'))
                                            アクション
                                        @endif
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




    <!-- Add Modal -->
    <div class="modal fade" id="add_company_modal" tabindex="-1" role="dialog" aria-labelledby="add_company_label"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="add_company_label">Add Company Information</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" id="add_company_forms" method="POST">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="region">会社名 <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_company_name"
                                        name="add_company_name" placeholder="会社名">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="region">頭字語<span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="company_name_acronym"
                                        name="company_name_acronym" placeholder="頭字語">
                                </div>
                            </div>
                            <!-- Province -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="province">VAT番号 <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_vat_number" name="add_vat_number"
                                        placeholder="VAT番号">
                                </div>
                            </div>

                            <!-- City -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city">電子メール <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_email" name="add_email"
                                        placeholder="電子メール">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="province">
                                        連絡先番号 <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_contact_number"
                                        name="add_contact_number" placeholder="連絡先番号">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city">電話番号 <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_tel_number" name="add_tel_number"
                                        placeholder="電話番号">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="region">住所 <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_address" name="add_address"
                                        placeholder="住所">
                                </div>
                            </div>
                            <!-- Province -->


                            <!-- City -->

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="add_department_multiselect">部門 <small>(選択複数の部門)</small> <span
                                            style="color:red"> * </span></label>
                                    <select class="w-100 select2-hidden-accessible" id="add_department_multiselect"
                                        name="add_department_multiselect[]" multiple="" tabindex="-1"
                                        aria-hidden="true">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <h5 class="modal-title" id="add_company_label">連絡先</h5><br>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="region">
                                        従業員番号 <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_emp_num" name="add_emp_num"
                                        placeholder="従業員番号">
                                </div>
                            </div>
                            <!-- Province -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="province">ファーストネーム<span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_first_name"
                                        name="add_first_name" placeholder="ファーストネーム">
                                </div>
                            </div>

                            <!-- City -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="city">ミドルネーム <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_middle_name"
                                        name="add_middle_name" placeholder="ミドルネーム">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="city">苗字 <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_last_name" name="add_last_name"
                                        placeholder="苗字">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="region"> 住所 <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_person_address"
                                        name="add_person_address" placeholder="住所">
                                </div>
                            </div>
                            <!-- Province -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="province">連絡先番号 <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_person_contact_number"
                                        name="add_person_contact_number" placeholder="連絡先番号">
                                </div>
                            </div>

                            <!-- City -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city">電子メール <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_person_email"
                                        name="add_person_email" placeholder="電子メール">
                                </div>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                    <button type="submit" class="btn btn-primary">変更を保存する</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="update_company_modal" tabindex="-1" role="dialog"
        aria-labelledby="update_company_label" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="update_company_label">update Company Information</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" id="update_company_forms" method="POST">
                        @csrf
                        @method('POST')
                        <input type="hidden" id="update_id" name="update_id">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="region">会社名 <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_company_name"
                                        name="update_company_name" placeholder="会社名">
                                </div>
                            </div>
                            <!-- Province -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="province">VAT番号 <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_vat_number"
                                        name="update_vat_number" placeholder="VAT番号">
                                </div>
                            </div>

                            <!-- City -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city">電子メール <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_email" name="update_email"
                                        placeholder="電子メール">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="region">住所 <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_address"
                                        name="update_address" placeholder="住所">
                                </div>
                            </div>
                            <!-- Province -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="province">連絡先番号 <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_contact_number"
                                        name="update_contact_number" placeholder="連絡先番号">
                                </div>
                            </div>

                            <!-- City -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city">電話番号<span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_tel_number"
                                        name="update_tel_number" placeholder="電話番号">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="update_department_multiselect">部門 <small>(複数の部門を選択してください)</small> <span style="color:red"> * </span></label>
                                    <select class="w-100 select2-hidden-accessible" id="update_department_multiselect"
                                        name="update_department_multiselect[]" multiple="" tabindex="-1"
                                        aria-hidden="true">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <h5 class="modal-title" id="add_company_label">連絡先</h5><br>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="region">E従業員番号 <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_emp_num"
                                        name="update_emp_num" placeholder="従業員番号">
                                </div>
                            </div>
                            <!-- Province -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="province">ファーストネーム <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_first_name"
                                        name="update_first_name" placeholder="ファーストネーム">
                                </div>
                            </div>

                            <!-- City -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="city">ミドルネーム <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_middle_name"
                                        name="update_middle_name" placeholder="ミドルネーム">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="city">苗字 <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_last_name"
                                        name="update_last_name" placeholder="苗字">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="region">住所 <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_person_address"
                                        name="update_person_address" placeholder="住所">
                                </div>
                            </div>
                            <!-- Province -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="province">連絡先番号 <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_person_contact_number"
                                        name="update_person_contact_number" placeholder="連絡先番号">
                                </div>
                            </div>

                            <!-- City -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city">Email <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_person_email"
                                        name="update_person_email" placeholder="電子メール">
                                </div>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                    <button type="submit" class="btn btn-primary">変更を保存する</button>
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
            $('#add_or_date').datepicker();
            $('#add_cr_date').datepicker();
        });
    </script>
    <script>
        //DATA TABLE FOR DRIVERS LIST
        let table = new DataTable('#table_id', {
            "processing": true,
            "serverSide": true,
            "language": {
                "sSearch": "会社名を検索する:"
            },
            "ajax": {
                "url": '{{ route('get-company') }}',
                "dataType": "json",
                "type": "GET",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columns": [{
                    "className": 'details-control',
                    "orderable": false,
                    "data": null,
                    "defaultContent": ''
                }, {
                    "data": "company_code"
                },
                {
                    "data": "company_name"
                },
                {
                    "data": "email"
                },
                {
                    "data": "address"
                },
                {
                    "data": "contact_number"
                },
                {
                    "data": "tel_number"
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
                "targets": [5, 6, 7, 8]
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


        function format(d) {
            data = d.arr;
            person_incharge = d.person_incharge;
            console.log(person_incharge.first_name);
            var output = "";
            output += `<br><h5>Company Department</h5><br><div class="col-md-12">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <th style="width: 50px;" class="text-center">#</th>
                            <th style="width: 70%;">Department Name</th>
                            <th>Status</th>
                        </thead>
                        <tbody>`;
            if (data.length > 0) {
                for (let index = 0; index < data.length; index++) {
                    output += `<tr>
                            <td class="text-center">${index + 1}</td>
                            <td>${data[index].departments_info.name}</td>
                            <td><span class="badge badge-success">${data[index].departments_info.status = 1 ? 'active' : 'inactive'}</span></td>
                        </tr>`;
                }
            } else {
                output += `<tr><td colspan="3" class="text-center">No Data Available</td></tr>`;
            }

            output += `</tbody>
                    </table>
                    </div>`;

            output += `<br><h5>Person Incharge</h5><br><div class="col-md-12">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <th style="width: 50px;" class="text-center">#</th>
                            <th>Employee No  </th>
                            <th>Fullname  </th>
                            <th>Address  </th>
                            <th>Email  </th>
                            <th>Contact No  </th>
                            <th>Status</th>
                        </thead>
                        <tbody>`;
            if (person_incharge.length > 0) {
                for (let i = 0; i < person_incharge.length; i++) {
                    output += `<tr>
                            <td class="text-center">${i + 1}</td>
                            <td>${person_incharge[i].employee_no}</td>
                            <td>${person_incharge[i].first_name+" "+person_incharge[i].middle_name+" "+person_incharge[i].last_name}</td>
                            <td>${person_incharge[i].home_address}</td>
                            <td>${person_incharge[i].email}</td>
                            <td>${person_incharge[i].contact_number}</td>
                            <td><span class="badge badge-success">${person_incharge[i].status = 1 ? 'active' : 'inactive'}</span></td>
                        </tr>`;
                }
            } else {
                output += `<tr><td colspan="3" class="text-center">No Data Available</td></tr>`;
            }

            output += `</tbody>
                    </table>
                    </div>`;

            return output;
        }

        // Add event listener for opening and closing details
        $('#table_id tbody').on('click', 'td.details-control', function() {

            let summary_datatable = $('#table_id').DataTable();
            var tr = $(this).closest('tr');
            var row = summary_datatable.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });




        //SHOW ADD NEW company TYPE MODAL
        const showModalAdd = () => {
            $("#add_company_forms").validate().resetForm();
            $("#add_company_modal").find(".modal-header > h5").text("新しい会社を追加 ").end()
                .modal('show');


        }

        //MULTI SELECT FUNCTION
        $(function() {
            $('#add_department_multiselect').select2({
                width: '100%',
                dropdownParent: $('#add_company_modal')
            });

            // $('#update_department_multiselect').select2({
            //     width: '100%',
            //     dropdownParent: $('#update_company_modal')
            // });

            addSelectDepartment();
        });

        //MULTI SELECT FUNCTION
        $(function() {
            $('#update_department_multiselect').select2({
                width: '100%',
                dropdownParent: $('#update_company_modal')
            });

            updateSelectDepartment();
        });




        const addSelectDepartment = () => {
            $.ajax({
                url: '{{ route('get-all-department') }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    for (let index = 0; index < response.length; index++) {
                        $('[name="add_department_multiselect[]"]').append('<option value=' +
                            response[index].id + '>' + response[index].name + '</option>');
                    }

                }
            });
        }


        const updateSelectDepartment = () => {
            $.ajax({
                url: '{{ route('get-all-department') }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {


                    for (let index = 0; index < response.length; index++) {
                        $('[name="update_department_multiselect[]"]').append('<option value=' +
                            response[index].id + '>' + response[index].name + '</option>');
                    }
                }
            });
        }


        const hideModalAdd = () => {
            $("#add_company_modal").modal('hide');
        }


        //ADD NEW COMPANY
        $(document).ready(function() {
            $("#add_company_forms").validate({
                rules: {
                    add_company_name: "required",
                    company_name_acronym: "required",
                    add_vat_number: "required",
                    add_email: "required",
                    add_address: "required",
                    add_contact_number: "required",
                    add_tel_number: "required",
                    add_emp_num: "required",
                    add_first_name: "required",
                    add_middle_name: "required",
                    add_last_name: "required",
                    add_person_address: "required",
                    add_person_contact_number: "required",
                    add_person_email: "required",
                    "add_department_multiselect[]": "required",
                },
                messages: {
                    add_company_name: "会社名を入力してください",
                    company_name_acronym: "会社の略称を入力してください",
                    add_vat_number: "VAT番号を入力してください",
                    add_email: "メールアドレスを入力してください",
                    add_address: "住所の入力をしてください",
                    add_contact_number: "連絡先番号を入力してください",
                    add_tel_number: "電話番号を入力してください",
                    add_emp_num: "従業員番号を入力してください",
                    add_first_name: "名を入力してください",
                    add_middle_name: "ミドルネームを入力してください",
                    add_last_name: "姓を入力してください",
                    add_person_address: "自宅の住所を入力してください",
                    add_person_contact_number: "連絡先番号を入力してください",
                    add_person_email: "メールアドレスを入力してください",
                    "add_department_multiselect[]": "部門を入力してください",
                },
                onfocusout: function(e) {
                    this.element(e);
                },
                onkeyup: false,
                highlight: function(element, errorClass, validClass) {
                    jQuery(element).closest('.form-control').addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    jQuery(element).closest('.form-control').removeClass('is-invalid');
                    jQuery(element).closest('.form-control').addClass('is-valid');
                },
                errorElement: 'div',
                errorClass: 'invalid-feedback',
                errorPlacement: function(error, element) {
                    if (element.parent('.input-group-prepend').length) {
                        $(element).siblings(".invalid-feedback").append(error);
                        //error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {

                    Swal.fire({
                        title: '実行しますか？',
                        text: "元に戻すことはできません",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: "キャンセル",   
                        confirmButtonText: 'はい。実行します',
                        //footer: '<a href = "mailto: jvn-cgs.com">Send an email to us!</a>'
                    }).then((result) => {
                        if (result.value) {

                            var formData = new FormData($("#add_company_forms").get(0));

                            $.ajax({
                                url: '/save-new-company',
                                type: "POST",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                dataType: "JSON",
                                beforeSend: function() {
                                    processObject.showProcessLoader();
                                },
                                success: function(data) {
                                    if (data.success) {
                                        // $('#addDriverModal').modal('hide');
                                        $("#add_company_forms")[0]
                                            .reset();
                                        var form = $(
                                            "#add_company_forms");
                                        form.validate().resetForm();
                                        form.find(".error").removeClass(
                                            "error");
                                        form.find(".form-control")
                                            .removeClass(
                                                "is-valid");
                                        table.ajax.reload(null, false);
                                        $('#add_company_modal').modal(
                                            'hide');

                                        swal.fire({
                                            title: "保存をします。",
                                            text: "正常に追加されました!",
                                            icon: 'success',
                                            type: "success",
                                            html: "<b>新しい会社情報が正常に保存されました。",
                                            // footer: '<a href = "mailto: enterprise.cabuyao@gmail.com">Send an email to us!</a>'
                                        });


                                    } else {
                                        swal.fire({
                                            title: "入力に間違いがあります。",
                                            icon: "error",
                                            html: "<b>" + data
                                                .messages +
                                                "! <br>予期しないエラーが発生しました。ページの更新をお願い致します。問題が解決しない場合は、管理者までお問い合わせください。</b>",
                                            type: "error",
                                            footer: ''
                                        });
                                    }
                                },
                                error: function(jqXHR, textStatus,
                                    errorThrown) {
                                    swal.fire({
                                        title: "入力に間違いがあります。",
                                        html: "<b>" + errorThrown +
                                            "! <br>予期しないエラーが発生しました。ページの更新をお願い致します。問題が解決しない場合は、管理者までお問い合わせください。</b>",
                                        type: "error",
                                        footer: ''
                                    });
                                },
                                complete: function() {
                                    processObject.hideProcessLoader();
                                },
                            });
                        }
                    })
                    // ---
                }
            });
        });

        //FORM VALIDATION FOR UPDATE
        $(document).ready(function() {
            $("#update_company_forms").validate({
                rules: {
                    update_company_name: "required",
                    update_vat_number: "required",
                    update_email: "required",
                    update_address: "required",
                    update_contact_number: "required",
                    update_tel_number: "required",
                    update_emp_num: "required",
                    update_first_name: "required",
                    update_middle_name: "required",
                    update_last_name: "required",
                    update_person_address: "required",
                    update_person_contact_number: "required",
                    update_person_email: "required",
                    "update_department_multiselect[]": "required",
                },
                messages: {
                    update_company_name: "会社名を入力してください",
                    update_vat_number: "VAT番号を入力してください",
                    update_email: "メールアドレスを入力してください",
                    update_address: "住所の入力をしてください",
                    update_contact_number: "連絡先番号を入力してください",
                    update_tel_number: "電話番号を入力してください",
                    update_emp_num: "従業員番号を入力してください",
                    update_first_name: "名を入力してください",
                    update_middle_name: "ミドルネームを入力してください",
                    update_last_name: "姓を入力してください",
                    update_person_address: "自宅の住所を入力してください",
                    update_person_contact_number: "連絡先番号を入力してください",
                    update_person_email: "メールアドレスを入力してください",
                    "add_department_multiselect[]": "部門を入力してください",
                },
                onfocusout: function(e) {
                    this.element(e);
                },
                onkeyup: false,
                highlight: function(element, errorClass, validClass) {
                    jQuery(element).closest('.form-control').addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    jQuery(element).closest('.form-control').removeClass('is-invalid');
                    jQuery(element).closest('.form-control').addClass('is-valid');
                },
                errorElement: 'div',
                errorClass: 'invalid-feedback',
                errorPlacement: function(error, element) {
                    if (element.parent('.input-group-prepend').length) {
                        $(element).siblings(".invalid-feedback").append(error);
                        //error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    //EVENT FOR SAVING
                    Swal.fire({
                        title: '実行しますか？',
                        text: "元に戻すことはできません",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: "キャンセル",   
                        confirmButtonText: '更新します。',
                        //footer: '<a href = "mailto: jvn-cgs.com">Send an email to us!</a>'
                    }).then((result) => {
                        if (result.value) {

                            var formData = new FormData($("#update_company_forms").get(
                                0));

                            $.ajax({
                                url: '/update-company-info',
                                type: "POST",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                dataType: "JSON",
                                beforeSend: function() {
                                    processObject.showProcessLoader();
                                },
                                success: function(data) {
                                    if (data.success) {
                                        $('#update_company_modal').modal(
                                            'hide');
                                        $("#update_company_forms")[0]
                                            .reset();
                                        var form = $(
                                            "#update_company_forms");
                                        form.validate().resetForm();
                                        form.find(".error").removeClass(
                                            "error");
                                        form.find(".form-control")
                                            .removeClass(
                                                "is-valid");
                                        $('#update_company_modal').modal(
                                            'hide');
                                        swal.fire({
                                            title: "更新されました！",
                                            text: "更新に成功しました。",
                                            icon: 'success',
                                            type: "success",
                                            html: "<b>会社詳細が正常に更新されました。",
                                            // footer: '<a href = "mailto: enterprise.cabuyao@gmail.com">Send an email to us!</a>'
                                        });

                                        table.ajax.reload(null, false);
                                    } else {
                                        Swal.fire({
                                            title: "入力に間違いがあります。",
                                            html: "<b>" + data
                                                .messages +
                                                "! <br>予期しないエラーが発生しました。ページの更新をお願い致します。問題が解決しない場合は、管理者までお問い合わせください。</b>",
                                            type: "error",
                                            icon: "error",
                                            footer: ''
                                        });
                                        table.ajax.reload(null, false);
                                    }
                                },
                                error: function(jqXHR, textStatus,
                                    errorThrown) {
                                    swal.fire({
                                        title: "入力に間違いがあります。",
                                        html: "<b>" + errorThrown +
                                            "! <br>予期しないエラーが発生しました。ページの更新をお願い致します。問題が解決しない場合は、管理者までお問い合わせください。</b>",
                                        type: "error",
                                        footer: ''
                                    });
                                },
                                complete: function() {
                                    processObject.hideProcessLoader();
                                },
                            });
                        }
                    })
                    // ---
                }
            });
        });

        //GET company TYPE INFO
        const update = (id) => {
            $.ajax({
                url: "/get-company-info-by-id/" + id,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                type: "GET",
                beforeSend: function() {
                    processObject.showProcessLoader();
                },
                success: function(data) {
                    console.log(data);
                    console.log(data.department_info.length);

                    if (data.success) {
                        $('#update_company_modal')
                            .find('.modal-header > h5')
                            .text("会社詳細の編集").end()
                            .modal('show');

                        $('#update_id').val(data.company_profile.id);
                        $('#update_company_name').val(data.company_profile.company_name);
                        $('#update_vat_number').val(data.company_profile.vat_no);
                        $('#update_email').val(data.company_profile.email);
                        $('#update_address').val(data.company_profile.address);
                        $('#update_contact_number').val(data.company_profile.contact_number);
                        $('#update_tel_number').val(data.company_profile.tel_number);

                        $('#update_emp_num').val(data.person_incharge.employee_no);
                        $('#update_first_name').val(data.person_incharge.first_name);
                        $('#update_middle_name').val(data.person_incharge.middle_name);
                        $('#update_last_name').val(data.person_incharge.last_name);
                        $('#update_person_email').val(data.person_incharge.email);
                        $('#update_person_address').val(data.person_incharge.home_address);
                        $('#update_person_contact_number').val(data.person_incharge.contact_number);
                        // $('#update_department_multiselect').val(data.data.company_info.color);

                        var selectedValues = new Array();
                        for (let index = 0; index < data.department_info.length; index++) {
                            selectedValues[index] = data.department_info[index].departments_info.id;
                        }
                        $('#update_department_multiselect').val(selectedValues).trigger('change');


                    } else {
                        Swal.fire({
                            title: "入力に間違いがあります。",
                            html: "<b>" + data.messages +
                                "! <br>予期しないエラーが発生しました。ページの更新をお願い致します。問題が解決しない場合は、管理者までお問い合わせください。</b>",
                            type: "error",
                            icon: "error",
                            footer: ''
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    swal.fire({
                        title: "入力に間違いがあります。",
                        text: errorThrown,
                        icon: 'success'
                    })
                },
                complete: function() {
                    processObject.hideProcessLoader();
                },
            });
        }



        //DELETE EVENT
        const removeCompanyRecord = (id) => {
            // const url = '{{ route('get-drivers') }}';
            Swal.fire({
                title: 'データを削除しますか?',
                icon: 'warning',
                text: "元に戻すことはできません",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: "キャンセル",   
                confirmButtonText: 'はい、取り外してください！'
            }).then((result) => {
                if (result.value) {
                    //process loader true
                    $.ajax({
                        url: "/remove-company-record/" + id,
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
                                    title: "削除されました！",
                                    text: "正常に削除されました!",
                                    icon: "success"
                                });
                            } else {
                                Swal.fire({
                                    title: "入力に間違いがあります。",
                                    text: data.messages,
                                    icon: 'success'
                                })
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            swal.fire({
                                title: "入力に間違いがあります。",
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
