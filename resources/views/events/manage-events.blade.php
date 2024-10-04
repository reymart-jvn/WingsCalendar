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

        /* td.details-control-ongoing {
                                                                                                    background: url('../assets/images/plus.png') no-repeat center center;
                                                                                                    cursor: pointer;
                                                                                                }

                                                                                                tr.shown td.details-control-ongoing {
                                                                                                    background: url('../assets/images/minus.png') no-repeat center center;
                                                                                                } */

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


                        {{-- <button type="button" onclick="showModalAdd()" class="btn btn-success btn-icon-tex">Add New
                                Event</button> --}}

                    </h4>

                    <p class="card-description">
                        {{ $label }}
                    </p>

                    <div class="row">
                        <div class="col-12">
                            <div class="row">

                                <div class="col-md-5">
                                    <!-- Barangay -->
                                    <div class="form-group">
                                        <div class="input-group">

                                            <input type="text" class="form-control " id="date_from" name="date_from"
                                                placeholder="データフォーム">
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <!-- Barangay -->
                                    <div class="form-group">
                                        <div class="input-group">

                                            <input type="text" class="form-control" id="date_to" name="date_to"
                                                placeholder="日付まで">

                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <!-- Barangay -->

                                    <button type="button" onclick="filterEventSchedule()" type="button"
                                        class="btn btn-primary btn-block btn-sm">フィルター</button>
                                    <button type="button" onclick="refreshEvents()"
                                        class="btn btn-warning btn-sm ">更新</button>
                                </div>

                            </div>


                        </div>
                    </div>
                    <hr>
                    <div class="table-responsive pt-3">
                        <table class="table table-hover" id="table_id">
                            <thead>
                                <tr>
                                    <th>
                                        タイトル
                                    </th>
                                    <th>
                                        タイプ
                                    </th>
                                    <th>
                                        場所
                                    </th>
                                    <th>
                                        日付時刻
                                    </th>
                                    <th>
                                        担当者
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



    <!-- Update Modal -->
    <div class="modal fade" id="update_event_modal" tabindex="-1" role="dialog" aria-labelledby="update_event_label"
        aria-hidden="true">
        <div class="modal-dialog modal-s" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="update_event_label">アップデートイベント</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" id="update_event_forms" method="POST">
                        @csrf
                        @method('POST')
                        <input type="hidden" id="update_id" name="update_id">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>タイトル <span style="color:red"> * </span></label>
                                    <input type="text" name="update_title" id="update_title" placeholder="Title"
                                        class="form-control ">
                                </div>

                                <div class="form-group">
                                    <label for="region">タイプ <span style="color:red"> *
                                        </span></label>
                                    <select class="selectpicker form-control" id="update_type" name="update_type">
                                        <option value="" disabled selected>選択...</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="region">場所 <span style="color:red"> *
                                        </span></label>
                                    <select class="selectpicker form-control" id="update_location" name="update_location">
                                        <option value="" disabled selected>選択...</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>時間<span style="color:red"> * </span></label>
                                    <input type="time" class="form-control" name="update_time" id="update_time">
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
            $("#date_from").datepicker({
                "dateFormat": "Y-m-d"

            });
            $("#date_to").datepicker({
                "dateFormat": "Y-m-d"
            });
        });
    </script>
    <script>
        let table = new DataTable('#table_id', {
            "processing": true,
            "serverSide": true,
            "language": {
                "sSearch": "イベント検索:",
                "paginate": {
                    "previous": "前へ",
                    "next": "次へ",
                }
            },
            "ajax": {
                "url": '{{ route('get-events') }}',
                "dataType": "json",
                "type": "GET",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columns": [{
                    "data": "title"
                },
                {
                    "data": "type"
                },
                {
                    "data": "location"
                },
                {
                    "data": "date_time"
                },
                {
                    "data": "person_in_charge"
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

        const filterEventSchedule = () => {
            let valueFrom = $("#date_from").val();
            let valueTo = $("#date_to").val();
            if (valueFrom != "" || valueTo != "") {
                $('#table_id').DataTable().clear().destroy();
                tbl_events = $('#table_id').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "language": {
                        "sSearch": "イベント検索"
                    },
                    "ajax": {
                        "url": '{{ route('get-filter-event-schedule') }}',
                        "dataType": "json",
                        "type": "GET",
                        "data": {
                            _token: "{{ csrf_token() }}",
                            valueFrom,
                            valueTo,
                        }
                    },
                    "columns": [{
                            "data": "title"
                        },
                        {
                            "data": "type"
                        },
                        {
                            "data": "location"
                        },
                        {
                            "data": "date_time"
                        },
                        {
                            "data": "person_in_charge"
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
            }

        }

        const refreshEvents = () => {
            $("#date_from").val("");
            $("#date_to").val("");
            $('#table_id').DataTable().clear().destroy();
            tbl_events = $('#table_id').DataTable({
                "processing": true,
                "serverSide": true,
                "language": {
                    "sSearch": "イベント検索"
                },
                "ajax": {
                    "url": '{{ route('get-events') }}',
                    "dataType": "json",
                    "type": "GET",
                    "data": {
                        _token: "{{ csrf_token() }}"
                    }
                },
                "columns": [{
                        "data": "title"
                    },
                    {
                        "data": "type"
                    },
                    {
                        "data": "location"
                    },
                    {
                        "data": "date_time"
                    },
                    {
                        "data": "person_in_charge"
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
                            tbl_events.search(this.value).draw();
                        }
                    });
                },
            });
        }


        $(document).ready(function() {
            $("#update_event_forms").validate({
                rules: {
                    update_title: "required",
                    update_type: "required",
                    update_location: "required",
                    update_time: "required",
                },
                messages: {
                    update_title: "タイトルを入力してください",
                    update_type: "タイプを入力してください",
                    update_location: "場所を入力してください",
                    update_time: "時間を入力してください",
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
                        //footer: '<a href = "mailto: jvn-cgs.com">Send an email to us!</a>'
                    }).then((result) => {

                        console.log('working');
                        if (result.value) {

                            var formData = new FormData($("#update_event_forms").get(0));

                            $.ajax({
                                url: '/update-event-schedule',
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
                                        $('#update_event_modal').modal('hide');
                                        $("#update_event_forms")[0].reset();
                                        var form = $("#update_event_forms");
                                        form.validate().resetForm();
                                        form.find(".error").removeClass("error");
                                        form.find(".form-control").removeClass(
                                            "is-valid");
                                        $('#update_location_modal').modal('hide');
                                        swal.fire({
                                            title: "更新",
                                            text: "更新に成功しました。",
                                            icon: 'success',
                                            type: "success",
                                            html: "<b>詳細場所の更新を行いました。",
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

            $("#update_type").empty();
            $("#update_location").empty();
            $.ajax({
                url: "/get-event-by-id/" + id,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                type: "GET",
                beforeSend: function() {
                    processObject.showProcessLoader();
                },
                success: function(data) {

                    // console.log(data.data)

                    if (data.success) {
                        $('#update_event_modal')
                            .find('.modal-header > h5')
                            .text("Edit event Details").end()
                            .modal('show');

                        console.log(data.data);

                        $.ajax({
                            url: '{{ route('list-activity') }}',
                            type: "GET",
                            data: {
                                _token: "{{ csrf_token() }}",
                                'company_id': data.data.company_id
                            },
                            dataType: "JSON",
                            success: function(response) {
                                let selectedTypeId = data.data.events_activity_web
                                    .activity_location.activity.id;

                                // Append options to the dropdown
                                for (let index = 0; index < response.length; index++) {
                                    let optionValue = response[index].id;
                                    let optionText = response[index].title;
                                    let $option = $('<option>', {
                                        value: optionValue,
                                        text: optionText
                                    });

                                    // Append the option
                                    $('#update_type').append($option);

                                    // Check if this option should be selected
                                    if (optionValue == selectedTypeId) {
                                        $option.prop('selected', true);
                                    }
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert(errorThrown);
                            }
                        });


                        $.ajax({
                            url: '{{ route('list-location') }}',
                            type: 'GET',
                            data: {
                                _token: "{{ csrf_token() }}",
                                'company_id': data.data.company_id
                            },
                            dataType: 'json',
                            success: function(response) {
                                let selectedLocationId = data.data.events_activity_web
                                    .activity_location.location.id;

                                // Append options to the dropdown
                                for (let index = 0; index < response.length; index++) {
                                    let optionValue = response[index].id;
                                    let optionText = response[index].description;
                                    let $option = $('<option>', {
                                        value: optionValue,
                                        text: optionText
                                    });

                                    // Append the option
                                    $('#update_location').append($option);

                                    // Check if this option should be selected
                                    if (optionValue == selectedLocationId) {
                                        $option.prop('selected', true);
                                    }
                                }
                            }
                        });
                        $('#update_id').val(data.data.id);
                        $('#update_title').val(data.data.title);
                        // $('#update_type').val(data.data.events_activity_web.activity_location.activity.id);
                        // $('#update_location').val(data.data.events_activity_web.activity_location.location
                        //     .id);

                        var datetimeString = data.data.events_activity_web.date_time;
                        var timeString = datetimeString.split(' ')[1];
                        let timeParts = timeString.split(':');
                        let formattedTime = timeParts[0] + ':' + timeParts[1]; // '10:00'

                        $('#update_time').val(formattedTime);



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

        const remove = (id) => {
            Swal.fire({
                title: 'イベントデータを消去しますか？',
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
                        url: "/remove-event/" + id,
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
                                    title: "削除!",
                                    text: "削除に成功しました。",
                                    icon: "success",
                                    html: "<b>イベントは正常に削除されました"
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
