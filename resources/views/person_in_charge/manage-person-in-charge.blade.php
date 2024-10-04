@extends('layouts.star-admin-app')
@section('css')
    <style>
        .btn-sm {

            border-radius: 0.1875rem !important;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-flex justify-content-between align-items-center">{{ $table_title }}
                        {{-- <button type="button" data-toggle="modal" data-target="#update_modal" class="btn btn-success btn-icon-tex">Add New Vehicle Type</button> --}}

                        <button type="button" onclick="showModalAdd()" class="btn btn-success btn-icon-tex">担当者の新規追加</button>

                    </h4>

                    <p class="card-description">
                        {{ $label }}
                    </p>


                    <div class="row">
                        <div class="col-12">
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select class="selectpicker form-control" id="filter_company" name="filter_company">
                                            <option value="" disabled selected>Filter By Company</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <!-- Barangay -->
                                    <div class="form-group">
                                        <div class="input-group">

                                            <input type="text" class="form-control " id="reset_start_date"
                                                name="reset_start_date" placeholder="Select Date to Start Reset">
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div>
                                            <button onclick="filterByCompany()" class="btn btn-block btn-sm btn-primary"
                                                id= "filterByCompany" name = "filterByCompany" disabled>フィルター</button>
                                            <button onclick="refreshPersonInCharge()"
                                                class="btn btn-sm btn-warning">リフレッシュする</button>
                                            <button onclick="resetCounter()" class="btn btn-sm btn-danger"
                                                id= "resetCounter" name = "resetCounter" disabled>カウンタをリセットする</button>

                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>


                    <div class="table-responsive pt-3">
                        <table class="table table-hover" id="table_id">
                            <thead>
                                <tr>
                                    <th>
                                        コード
                                    </th>
                                    @if (is_super_admin())
                                        <th>
                                            Company
                                        </th>
                                    @endif
                                    <th>
                                        指名
                                    </th>
                                    <th>
                                        利用状況
                                    </th>

                                    <th>
                                        今月担当回数
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
                    <form class="forms-sample" id="reset_counter_forms" method="POST">
                        @csrf
                        @method('POST')
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Add Modal -->
    <div class="modal fade" id="add_person_modal" tabindex="-1" role="dialog" aria-labelledby="add_person_label"
        aria-hidden="true">
        <div class="modal-dialog modal-s" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="add_person_label">Add person</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" id="add_person_forms" method="POST">
                        @csrf
                        @method('POST')
                        <input type="hidden" id="add_id" name="add_id">

                        @if (is_super_admin())
                            <div class="row">
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="region">会社 <span style="color:red"> * </span></label>
                                        <select class="selectpicker form-control" id="add_company" name="add_company">
                                            <option value="" disabled selected>選択...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="add_fullname">指名 <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_fullname" name="add_fullname"
                                        placeholder="指名">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="add_email">電子メール</label>
                                    <input id="add_email" type="email" name="add_email" required class="form-control"
                                        placeholder="電子メール">
                                </div>
                            </div>
                        </div>



                        {{-- <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="region">利用状況 <span style="color:red"> *
                                        </span></label>
                                    <select class="selectpicker form-control" id="add_availability" name="add_availability">
                                        <option value="全て" selected>全て</option>
                                        <option value="平日">平日</option>
                                        <option value="週末">週末</option>
                                    </select>
                                </div>
                            </div>
                        </div> --}}

                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="region">利用状況 <span style="color:red"> *
                                        </span></label>
                                    <select class="select2-hidden-accessible" id="add_availability"
                                        name="add_availability[]" multiple="" tabindex="-1" aria-hidden="true">
                                        <option value="月曜日">月曜日</option>
                                        <option value="火曜日">火曜日</option>
                                        <option value="水曜日">水曜日</option>
                                        <option value="木曜日">木曜日</option>
                                        <option value="金曜日">金曜日</option>
                                        <option value="土曜日">土曜日</option>
                                        <option value="日曜日">日曜日</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                    <button type="submit" class="btn btn-primary">提出</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="update_person_modal" tabindex="-1" role="dialog"
        aria-labelledby="update_person_label" aria-hidden="true">
        <div class="modal-dialog modal-s" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="update_person_label">Update person</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" id="update_person_forms" method="POST">
                        @csrf
                        @method('POST')
                        <input type="hidden" id="update_id" name="update_id">
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="update_fullname">指名<span style="color:red"> *
                                        </span></label>
                                    <input type="text" class="form-control " id="update_fullname"
                                        name="update_fullname" placeholder="指名">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="region">利用状況 <span style="color:red"> *
                                        </span></label>
                                    <select class="select2-hidden-accessible" id="update_availability"
                                        name="update_availability[]" multiple="" tabindex="-1" aria-hidden="true">
                                        <option value="月曜日">月曜日</option>
                                        <option value="火曜日">火曜日</option>
                                        <option value="水曜日">水曜日</option>
                                        <option value="木曜日">木曜日</option>
                                        <option value="金曜日">金曜日</option>
                                        <option value="土曜日">土曜日</option>
                                        <option value="日曜日">日曜日</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                    <button type="submit" class="btn btn-primary">変更の保存</button>
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
            $("#reset_start_date").datepicker({
                "dateFormat": "Y-m-d"

            });
        });
    </script>
    <script>
        let table;
        let columns = [{
                "data": "code"
            },
            {
                "data": "fullname"
            },
            {
                "data": "availability"
            },
            {
                "data": "total_incharge_this_month"
            },
            {
                "data": "status"
            },
            {
                "data": "actions"
            },
        ];

        fetch('/is-super-admin')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                var isSuperAdmin = data.isSuperAdmin;
                console.log('Is Super Admin:', isSuperAdmin);
                if (isSuperAdmin) {
                    // Add the "company" column for super admin
                    columns.splice(1, 0, {
                        "data": "company"
                    });
                }

                // Initialize DataTable only after determining the columns
                initializeDataTable(columns);
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });


        $('#filter_company').on("change", function(e) {
            if ($('#filter_company').val() != "")

                $("#filterByCompany").prop("disabled", false);
            $("#reset_start_date").prop("disabled", false);


        });


        $('#reset_start_date').on("change", function(e) {
            if ($('#reset_start_date').val() != "")

                $("#resetCounter").prop("disabled", false);


        });


        function initializeDataTable(columns) {
            table = new DataTable('#table_id', {
                "processing": true,
                "serverSide": true,
                "language": {
                    "sSearch": "名前検索:",
                    "paginate": {
                        "previous": "前へ",
                        "next": "次へ",
                    }
                },
                "ajax": {
                    "url": '{{ route('get-personincharge') }}',
                    "dataType": "json",
                    "type": "GET",
                    "data": {
                        _token: "{{ csrf_token() }}"
                    }
                },
                "columns": columns,
                // "columnDefs": [{
                //     "orderable": false,
                //     "targets": [2, 3]
                // }, ],
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
        }





        //DATA TABLE FOR DRIVERS LIST


        $.ajax({
            url: '{{ route('get-all-company') }}',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log(response);
                for (let index = 0; index < response.length; index++) {
                    // console.log(response[index].vehicle_type_name);
                    $('[name="add_company"]').append('<option value=' + response[index].id + '>' +
                        response[index].company_name + '</option>');
                    $('[name="update_company"]').append('<option value=' + response[index].id + '>' +
                        response[index].company_name + '</option>');
                }

            }
        });

        //SHOW ADD NEW VEHICLE TYPE MODAL
        const showModalAdd = () => {
            $("#add_person_forms").validate().resetForm();
            $("#add_person_modal").find(".modal-header > h5").text("新しい担当者を追加").end()
                .modal('show');
        }


        $('#add_person_modal').on('shown.bs.modal', function() {
            $('#add_availability').select2({
                width: '100%',
                placeholder: "空き状況を選択してください",
                dropdownParent: $('#add_person_modal')
            });
        });

        $('#update_person_modal').on('shown.bs.modal', function() {
            $('#update_availability').select2({
                width: '100%',
                placeholder: "空き状況を選択してください",
                dropdownParent: $('#update_person_modal'),

            });
        });

        $.ajax({
            url: '{{ route('get-all-company') }}',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                for (let index = 0; index < response.length; index++) {
                    // console.log(response[index].vehicle_type_name);
                    $('[name="filter_company"]').append('<option value=' + response[index].id + '>' +
                        response[index].company_name + '</option>');

                }

            }
        });

        const resetCounter = () => {
            Swal.fire({
                title: 'Do want to reset the counter?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Reset it!',
                //footer: '<a href = "mailto: jvn-cgs.com">Send an email to us!</a>'
            }).then((result) => {
                if (result.value) {
                    // JSON.stringify(passengerGroupID)

                    var formData = new FormData($("#reset_counter_forms").get(0));
                    var selectedCompany = document.getElementById('filter_company').value;
                    var resetStartDate = document.getElementById('reset_start_date').value;

                    // Append the values to the FormData object
                    formData.append('company_id', selectedCompany);
                    formData.append('reset_start_date', resetStartDate);

                    $.ajax({
                        url: '/reset-counter-start-date',
                        type: "POST",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: "JSON",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function() {
                            processObject.showProcessLoader();
                        },
                        success: function(data) {
                            if (data.success) {
                                // selectedBookingCodesForApproval = [];
                                swal.fire({
                                    title: "Success!",
                                    text: "Successfully Reset!",
                                    icon: 'success',
                                    type: "success",
                                    html: "<b>Person in charge counter successfully",
                                    // footer: '<a href = "mailto: enterprise.cabuyao@gmail.com">Send an email to us!</a>'
                                });
                                table.ajax.reload(null, false);
                            } else {
                                Swal.fire({
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
                                title: "Oops! something went wrong.",
                                html: "<b>" + errorThrown +
                                    "! <br>An unexpected error seems to have occured. Why not try refreshing your page? Or you can contact us if the problem persists.</b>",
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
        }

        const refreshPersonInCharge = () => {
            $('#filter_company').val("");
            $('#table_id').DataTable().clear().destroy();

            let columnsRefresh = [{
                    "data": "code"
                },
                {
                    "data": "fullname"
                },
                {
                    "data": "availability"
                },
                {
                    "data": "total_incharge_this_month"
                },
                {
                    "data": "status"
                },
                {
                    "data": "actions"
                },
            ];

            fetch('/is-super-admin')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    var isSuperAdmin = data.isSuperAdmin;
                    console.log('Is Super Admin:', isSuperAdmin);
                    if (isSuperAdmin) {
                        // Add the "company" column for super admin
                        columnsRefresh.splice(1, 0, {
                            "data": "company"
                        });
                    }

                    // Initialize DataTable only after determining the columns
                    initializeDataTableRefresh(columnsRefresh);
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });


            function initializeDataTableRefresh(columnsRefresh) {
                table = new DataTable('#table_id', {
                    "processing": true,
                    "serverSide": true,
                    "language": {
                        "sSearch": "名前検索:",
                        "paginate": {
                            "previous": "前へ",
                            "next": "次へ",
                        }
                    },
                    "ajax": {
                        "url": '{{ route('get-personincharge') }}',
                        "dataType": "json",
                        "type": "GET",
                        "data": {
                            _token: "{{ csrf_token() }}"
                        }
                    },
                    "columns": columns,
                    // "columnDefs": [{
                    //     "orderable": false,
                    //     "targets": [2, 3]
                    // }, ],
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
            }

        }

        const filterByCompany = () => {

            let columnsFilter = [{
                    "data": "code"
                },
                {
                    "data": "fullname"
                },
                {
                    "data": "availability"
                },
                {
                    "data": "total_incharge_this_month"
                },
                {
                    "data": "status"
                },
                {
                    "data": "actions"
                },
            ];

            fetch('/is-super-admin')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    var isSuperAdmin = data.isSuperAdmin;
                    console.log('Is Super Admin:', isSuperAdmin);
                    if (isSuperAdmin) {
                        // Add the "company" column for super admin
                        columnsFilter.splice(1, 0, {
                            "data": "company"
                        });
                    }

                    initializeDataTableFilterByCompany(columnsFilter);
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });

            function initializeDataTableFilterByCompany(columnsFilter) {
                let filter_company_id = $('#filter_company').val();
                $('#table_id').DataTable().clear().destroy();

                table = new DataTable('#table_id', {
                    "processing": true,
                    "serverSide": true,
                    "language": {
                        "sSearch": "名前検索:",
                        "paginate": {
                            "previous": "前へ",
                            "next": "次へ",
                        }
                    },
                    "ajax": {
                        "url": '{{ route('get-filter-by-company') }}',
                        "dataType": "json",
                        "type": "GET",
                        "data": {
                            _token: "{{ csrf_token() }}",
                            filter_company_id,
                        }
                    },
                    "columns": columns,
                    // "columnDefs": [{
                    //     "orderable": false,
                    //     "targets": [2, 3]
                    // }, ],
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
            }


        }


        //ADD NEW VEHICLE TYPE
        $(document).ready(function() {
            $("#add_person_forms").validate({
                rules: {
                    add_fullname: "required",
                    add_availability: "required",

                },
                messages: {
                    add_fullname: "フルネームを入力してください",
                    add_availability: "平日・週末の設定",
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
                        confirmButtonText: 'はい。実行します',
                        cancelButtonText: 'キャンセル'
                        //footer: '<a href = "mailto: jvn-cgs.com">Send an email to us!</a>'
                    }).then((result) => {
                        if (result.value) {


                            var formData = new FormData($("#add_person_forms").get(0));

                            $.ajax({
                                url: '/save-new-person-in-charge',
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
                                        $("#add_person_forms")[0].reset();
                                        var form = $("#add_person_forms");
                                        form.validate().resetForm();
                                        form.find(".error").removeClass("error");
                                        form.find(".form-control").removeClass(
                                            "is-valid");
                                        table.ajax.reload(null, false);
                                        $('#add_person_modal').modal('hide');

                                        swal.fire({
                                            title: "保存をします。",
                                            text: "保存に成功しました",
                                            icon: 'success',
                                            type: "success",
                                            html: "<b>新規担当者を追加保存しました。",
                                            // footer: '<a href = "mailto: enterprise.cabuyao@gmail.com">Send an email to us!</a>'
                                        });
                                    } else {
                                        swal.fire({
                                            title: "入力に間違いがあります。",
                                            icon: "error",
                                            html: "<h4>" + data
                                                .messages +
                                                "</h4>",
                                            type: "error",
                                            footer: ''
                                        });
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
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
            $("#update_person_forms").validate({
                rules: {
                    update_fullname: "required",
                    update_availability: "required",
                },
                messages: {
                    update_fullname: "フルネームを入力してください",
                    update_availability: "平日・週末の設定",
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
                        confirmButtonText: '更新します。',
                        cancelButtonText: 'キャンセル'
                        //footer: '<a href = "mailto: jvn-cgs.com">Send an email to us!</a>'
                    }).then((result) => {

                        console.log('working');
                        if (result.value) {

                            var formData = new FormData($("#update_person_forms").get(0));

                            $.ajax({
                                url: '/update-person-in-charge',
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
                                        $('#update_person_modal').modal('hide');
                                        $("#update_person_forms")[0].reset();
                                        var form = $("#update_person_forms");
                                        form.validate().resetForm();
                                        form.find(".error").removeClass("error");
                                        form.find(".form-control").removeClass(
                                            "is-valid");
                                        $('#update_person_modal').modal('hide');
                                        swal.fire({
                                            title: "更新",
                                            text: "更新に成功しました。",
                                            icon: 'success',
                                            type: "success",
                                            html: "<b>担当者情報の更新を保存しました。",
                                            // footer: '<a href = "mailto: enterprise.cabuyao@gmail.com">Send an email to us!</a>'
                                        });
                                        table.ajax.reload(null, false);
                                    } else {
                                        swal.fire({
                                            title: "入力に間違いがあります。",
                                            icon: "error",
                                            html: "<h4>" + data
                                                .messages +
                                                "</h4>",
                                            type: "error",
                                            footer: ''
                                        });
                                        table.ajax.reload(null, false);
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
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
                }
            });
        });


        const update = (id) => {
            $.ajax({
                url: "/get-personincharge-by-id/" + id,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                type: "GET",
                beforeSend: function() {
                    processObject.showProcessLoader();
                },
                success: function(data) {
                    if (data.success) {
                        $('#update_person_modal')
                            .find('.modal-header > h5')
                            .text("個人の詳細を編集する").end()
                            .modal('show');
                        $('#update_id').val(data.data.id);
                        $('#update_fullname').val(data.data.fullname);
                        $('#update_availability').val(data.data.availability);

                    } else {
                        swal.fire({
                            title: "入力に間違いがあります。",
                            icon: "error",
                            html: "<h4>" + data
                                .messages +
                                "</h4>",
                            type: "error",
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
        const remove = (id) => {
            Swal.fire({
                title: 'この担当者の情報を削除しますか？',
                icon: 'warning',
                text: "元に戻すことはできません",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'はい、削除します。',
                cancelButtonText: 'キャンセル'
            }).then((result) => {
                if (result.value) {
                    //process loader true
                    $.ajax({
                        url: "/remove-personincharge/" + id,
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
                                    title: "削除",
                                    text: "削除に成功しました。",
                                    icon: "success",
                                    html: "<b>担当者の情報を完全に削除しました。"
                                });
                            } else {
                                swal.fire({
                                    title: "入力に間違いがあります。",
                                    icon: "error",
                                    html: "<h4>" + data
                                        .messages +
                                        "</h4>",
                                    type: "error",
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
            })
        };
    </script>
@endsection
