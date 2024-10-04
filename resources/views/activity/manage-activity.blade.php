@extends('layouts.star-admin-app')
@section('css')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-flex justify-content-between align-items-center">{{ $table_title }}
                        {{-- <button type="button" data-toggle="modal" data-target="#update_modal" class="btn btn-success btn-icon-tex">Add New Vehicle Type</button> --}}

                        @if (Gate::allows('permission', 'createActivities') || is_super_admin() == true)
                        <button type="button" onclick="showModalAdd()" class="btn btn-success btn-icon-tex">新規活動の追加</button>
                        @endif

                    </h4>

                    <p class="card-description">
                        {{ $label }}
                    </p>
                    <div class="table-responsive pt-3">
                        <table class="table table-hover" id="table_id">
                            <thead>
                                <tr>

                                    <th>
                                        タイトル
                                    </th>
                                    <th>
                                        詳細
                                    </th>

                                    @if (is_super_admin())
                                        <th>
                                            会社
                                        </th>
                                    @endif
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


    <!-- Add Modal -->
    <div class="modal fade" id="add_activity_modal" tabindex="-1" role="dialog" aria-labelledby="add_activity_label"
        aria-hidden="true">
        <div class="modal-dialog modal-s" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="add_activity_label">Add activity</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" id="add_activity_forms" method="POST">
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
                                    <label for="add_activity_name">タイトル <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_title" name="add_title"
                                        placeholder="タイトル">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="add_description">詳細 <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_description" name="add_description"
                                        placeholder="詳細">
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
    <div class="modal fade" id="update_activity_modal" tabindex="-1" role="dialog" aria-labelledby="update_activity_label"
        aria-hidden="true">
        <div class="modal-dialog modal-s" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="update_activity_label">活動の更新</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" id="update_activity_forms" method="POST">
                        @csrf
                        @method('POST')
                        <input type="hidden" id="update_id" name="update_id">
                        @if (is_super_admin())
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="region">会社 <span style="color:red"> * </span></label>
                                    <select class="selectpicker form-control" id="update_company" name="update_company">
                                        <option value="" disabled selected>選択...</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="update_activity_name">タイトル<span style="color:red"> *
                                        </span></label>
                                    <input type="text" class="form-control " id="update_title" name="update_title"
                                        placeholder="タイトル">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="update_address">詳細 <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_description"
                                        name="update_description" placeholder="詳細">
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
        let table;
        let columns = [{
                "data": "title"
            },
            {
                "data": "description"
            },
            {
                "data": "status"
            },
            {
                "data": "actions"
            }
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
                    columns.splice(2, 0, {
                        "data": "company"
                    });
                }

                // Initialize DataTable only after determining the columns
                initializeDataTable(columns);
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });

        function initializeDataTable(columns) {
             table = new DataTable('#table_id', {
                "processing": true,
                "serverSide": true,
                "language": {
                    "sSearch": "活動の更新:",
                    "paginate": {
                        "previous": "前へ",
                        "next": "次へ",
                    }
                },
                "ajax": {
                    "url": '{{ route('get-activity') }}',
                    "dataType": "json",
                    "type": "GET",
                    "data": {
                        _token: "{{ csrf_token() }}"
                    }
                },
                "columns": columns,
                "columnDefs": [{
                    "orderable": false,
                    "targets": columns.length - 1 // Disable ordering for actions column
                }],
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
        //SHOW ADD NEW VEHICLE TYPE MODAL
        const showModalAdd = () => {
            $("#add_activity_forms").validate().resetForm();
            $("#add_activity_modal").find(".modal-header > h5").text("新しいアクティビティの追加").end()
                .modal('show');
        }

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



        //ADD NEW VEHICLE TYPE
        $(document).ready(function() {
            $("#add_activity_forms").validate({
                rules: {
                    add_title: "required",
                    add_description: "required",

                },
                messages: {
                    add_title: "活動名を入力してください",
                    add_description: "説明を入力してください",
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
                        //footer: '<a href = "mailto: jvn-cgs.com">Send an email to us!</a>'
                    }).then((result) => {
                        if (result.value) {


                            var formData = new FormData($("#add_activity_forms").get(0));

                            $.ajax({
                                url: '/save-new-activity',
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
                                        $("#add_activity_forms")[0].reset();
                                        var form = $("#add_activity_forms");
                                        form.validate().resetForm();
                                        form.find(".error").removeClass("error");
                                        form.find(".form-control").removeClass(
                                            "is-valid");
                                        table.ajax.reload(null, false);
                                        $('#add_activity_modal').modal('hide');

                                        swal.fire({
                                            title: "保存をします。",
                                            text: "保存に成功しました",
                                            icon: 'success',
                                            type: "success",
                                            html: "<b>新規活動の保存をしました。",
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
            $("#update_activity_forms").validate({
                rules: {
                    update_title: "required",
                    update_description: "required",
                },
                messages: {
                    update_title: "活動名を入力してください",
                    update_description: "説明を入力してください",
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

                            var formData = new FormData($("#update_activity_forms").get(0));

                            $.ajax({
                                url: '/update-activity',
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
                                        $('#update_activity_modal').modal('hide');
                                        $("#update_activity_forms")[0].reset();
                                        var form = $("#update_activity_forms");
                                        form.validate().resetForm();
                                        form.find(".error").removeClass("error");
                                        form.find(".form-control").removeClass(
                                            "is-valid");
                                        $('#update_activity_modal').modal('hide');
                                        swal.fire({
                                            title: "更新",
                                            text: "更新に成功しました。",
                                            icon: 'success',
                                            type: "success",
                                            html: "<b>活動の更新を保存しました。",
                                            // footer: '<a href = "mailto: enterprise.cabuyao@gmail.com">Send an email to us!</a>'
                                        });
                                        table.ajax.reload(null, false);
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
                url: "/get-activity-by-id/" + id,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                type: "GET",
                beforeSend: function() {
                    processObject.showProcessLoader();
                },
                success: function(data) {
                    if (data.success) {
                        $('#update_activity_modal')
                            .find('.modal-header > h5')
                            .text("アクティビティの詳細を編集する").end()
                            .modal('show');
                        $('#update_id').val(data.data.id);
                        $('#update_title').val(data.data.title);
                        $('#update_description').val(data.data.description);
                        $('#update_company').val(data.data.company_id);

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
                title: '活動を削除しますか？',
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
                        url: "/remove-activity/" + id,
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
                                    html: "<b>活動の削除を実行しました"
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
