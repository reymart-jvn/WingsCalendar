@extends('layouts.star-admin-app')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="col-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-flex justify-content-between align-items-center">{{ $table_title }} </h4>

                    {{-- <p class="card-description">
                        {{ $label }}
                    </p> --}}

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="home-tab">
                    <div class="tab-content tab-content-basic">
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                            <div class="row">
                                <div class="col-lg-7 grid-margin grid-margin-lg-0 stretch-card">
                                    <div class="card">
                                        <div class="card-body">


                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div id="calendar">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 grid-margin grid-margin-lg-0 stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <form class="forms-sample" id="add_event_form" method="POST">
                                                @csrf
                                                @method('POST')
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        @if (is_super_admin())
                                                            <div class="form-group">
                                                                <label for="region">会社 <span style="color:red"> *
                                                                    </span></label>
                                                                <select class="selectpicker form-control" id="add_company"
                                                                    name="add_company">
                                                                    <option value="" disabled selected>選択...
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        @endif
                                                        <div class="form-group">
                                                            <label>タイトル <span style="color:red"> * </span></label>
                                                            <input type="text" name="add_title" id="add_title"
                                                                placeholder="タイトル" class="form-control ">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="region">タイプ <span style="color:red"> *
                                                                </span></label>
                                                            <select class="selectpicker form-control" id="add_type"
                                                                name="add_type">
                                                                <option value="" disabled selected>選択...</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="region">場所 <span style="color:red"> *
                                                                </span></label>
                                                            <select class="selectpicker form-control" id="add_location"
                                                                name="add_location">
                                                                <option value="" disabled selected>選択...</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>時間 <span style="color:red"> * </span></label>
                                                            <input type="time" class="form-control" name="add_time"
                                                                id="add_time">
                                                        </div>
                                                    </div>
                                                </div>

                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="d-flex justify-content-between">
                                                        <button type="submit" class="btn btn-primary btn-lg flex-fill mr-2"
                                                            id= "saveNewEventButton" name="saveNewEventButton"
                                                            style="color: white" disabled>提出</button>
                                                        <button type="button"
                                                            class="btn btn-secondary btn-lg flex-fill ml-2">キャンセル</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/js/ph_address.js') }}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/locale/ja.js"></script> --}}

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script> --}}
    <script>
        var selectedDates = [];
        let globalCompanyId = "";

        const showModalAdd = () => {
            $("#add_activity_forms").validate().resetForm();
            $("#add_activity_modal").find(".modal-header > h5").text("Add New Activity").end()
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

                }

                if (response.length > 0) {
                    $('[name="add_company"]').val(response[0].id);
                    globalCompanyId = response[0].id;
                }


                $.ajax({
                    url: '{{ route('list-activity') }}',
                    type: "GET",
                    data: {
                        _token: "{{ csrf_token() }}",
                        'company_id': globalCompanyId
                    },
                    dataType: "JSON",
                    success: function(response) {
                        for (let index = 0; index < response.length; index++) {
                            // console.log(response[index].booking_type_name);
                            $('[name="add_type"]').append('<option value=' + response[index].id +
                                '>' +
                                response[index].title + '</option>');
                        }

                        if (response.length > 0) {
                            $('#add_type').val(response[0].id);
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
                        'company_id': globalCompanyId
                    },
                    dataType: 'json',
                    success: function(response) {
                        for (let index = 0; index < response.length; index++) {
                            // console.log(response[index].booking_type_name);
                            $('[name="add_location"]').append('<option value=' + response[index]
                                .id + '>' +
                                response[index].description + '</option>');
                        }

                        if (response.length > 0) {
                            $('#add_location').val(response[0].id);
                        }
                    }
                });


            }
        });

        $("#add_company").change(function() {
            $("#add_type").prop('disabled', false);
            $("#add_type").empty();
            $("#add_location").prop('disabled', false);
            $("#add_location").empty();
            // $("#position").prop('disabled', false);
            // $("#position").empty();
            let companyId = $(this).val();
            $.ajax({
                url: '{{ route('list-activity') }}',
                type: "GET",
                data: {
                    _token: "{{ csrf_token() }}",
                    'company_id': companyId
                },
                dataType: "JSON",
                success: function(response) {
                    for (let index = 0; index < response.length; index++) {
                        // console.log(response[index].booking_type_name);
                        $('[name="add_type"]').append('<option value=' + response[index].id + '>' +
                            response[index].title + '</option>');
                    }

                    // Optionally, automatically select the first activity type
                    if (response.length > 0) {
                        $('#add_type').val(response[0].id);
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
                    'company_id': companyId
                },
                dataType: 'json',
                success: function(response) {
                    for (let index = 0; index < response.length; index++) {
                        // console.log(response[index].booking_type_name);
                        $('[name="add_location"]').append('<option value=' + response[index].id + '>' +
                            response[index].description + '</option>');
                    }

                    if (response.length > 0) {
                        $('#add_location').val(response[0].id);
                    }
                }
            });
        });

        $(document).ready(function() {
            $("#add_event_form").validate({
                rules: {
                    add_title: "required",
                    add_type: "required",
                    add_location: "required",
                    add_time: "required",

                },
                messages: {
                    add_title: "タイトルを入力してください",
                    add_type: "タイプを入力してください",
                    add_location: "場所を入力してください",
                    add_time: "時間を入力してください",
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


                            var formData = new FormData($("#add_event_form").get(0));
                            formData.append('selectedDates', JSON.stringify(selectedDates));

                            $.ajax({
                                url: '/save-new-event',
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
                                        $("#add_event_form")[0].reset();
                                        var form = $("#add_event_form");
                                        form.validate().resetForm();
                                        form.find(".error").removeClass("error");
                                        form.find(".form-control").removeClass(
                                            "is-valid");
                                        selectedDates = [];


                                        swal.fire({
                                            title: "保存をします。",
                                            text: "保存に成功しました",
                                            icon: 'success',
                                            type: "success",
                                            html: "<b>イベントは保存されました。",
                                            // footer: '<a href = "mailto: enterprise.cabuyao@gmail.com">Send an email to us!</a>'
                                        });

                                        location.reload();

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
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                      
                locale: 'ja', // Set the language to Japanese
                dayNames: ['日曜日', '月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日'],

                header: {
                    left: 'prev, next today',
                    center: 'title',
                    right: 'month, agendaWeek, agendaDay',
                },
                selectable: true,
                selectHelper: true,
                unselectAuto: false,
                select: function(start, end, allDays) {
                    // $('#eventdetailsModal').modal('toggle');
                },
                views: {
                    month: {
                        dayHeaderFormat: {
                            weekday: 'long', // Use 'long' for full names
                            // or specify a specific locale format
                            // like 'yyyy-MM-dd' if needed
                        }
                    }
                },
                editable: true,
                eventDrop: function(event) {
                    var id = event.id;
                    var start_date = moment(event.start).format('YYYY-MM-DD');
                    var end_date = moment(event.end).format('YYYY-MM-DD');
                },
                eventClick: function(event) {

                },
                dayClick: function(date, allDay, jsEvent, view) {



                    var index = selectedDates.findIndex(function(selectedDate) {
                        return selectedDate.isSame(date, 'day');
                    });

                    if (index === -1) {
                        // If the date is not already selected, add it to the array
                        selectedDates.push(date);
                        $(this).css('color', 'red');
                        $('#calendar').fullCalendar('select', date, date);
                    } else {
                        // If the date is already selected, remove it from the array
                        selectedDates.splice(index, 1);
                        // $(this).removeClass('fc-highlight');
                        $('#calendar').fullCalendar('unselect');
                    }

                    // Format the selected dates in yyyy-mm-dd format
                    var formattedDates = selectedDates.map(function(selectedDate) {
                        return selectedDate.format('YYYY-MM-DD');
                    });



                    if (selectedDates.length > 0) {
                        $("#saveNewEventButton").prop('disabled', false);
                    } else {
                        $("#saveNewEventButton").prop('disabled', false);
                    }

                    $('td[data-date="' + date.format() + '"]').toggleClass('fc-highlight');

                },
                selectAllow: function(event) {
                    return moment(event.start).utcOffset(false).isSame(moment(event.end).subtract(1,
                        'second').utcOffset(false), 'day');
                },
                monthNames: ['いちがつ', 'にがつ', 'さんがつ', 'しがつ', 'ごがつ', 'ろくがつ', 'しちがつ', 'はちがつ', 'くがつ', 'じゅうがつ',
                    'じゅういちがつ', 'じゅうにがつ'
                ],
          
            });

            $.ajax({
                url: '/view-calendar-event', // Update the URL with your route
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    processObject.showProcessLoader();
                },
                success: function(response) {
                    if (response.success) {
                        // Parse event data and render on FullCalendar

                        var events = [];
                        response.data.forEach(function(event) {
                            events.push({
                                title: event.events.title,
                                location: event.activity_location.location.description,
                                address: event.activity_location.location
                                    .location_address,
                                start: event.date_time,
                                end: event.date_time,
                                time: event.date_time,
                                incharge1: event.event_activity_in_charge[0]
                                    .person_incharge.fullname,
                                incharge2: event.event_activity_in_charge[1]
                                    .person_incharge.fullname,
                            });
                        });
                        $('#calendar').fullCalendar('renderEvents', events, true);
                    } else {
                        console.error(response.message);
                    }
                },
                complete: function() {
                    processObject.hideProcessLoader();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });

            $(window).resize(function() {
                $('#calendar').fullCalendar('option', {
                    'height': $(window).height() - 400,
                    'width': $(window).width() - 400 // Adjust the width as needed
                });
            });
            // Trigger window resize event
            $(window).trigger('resize');
            $('.fc-event').css('font-size', '13px');
            $('.fc-event').css('width', '20px');
            $('.fc-event').css('border-radius', '50%');
        });


        // $.ajax({
        //     url: '{{ route('list-activity') }}',
        //     type: 'GET',
        //     dataType: 'json',
        //     success: function(response) {
        //         for (let index = 0; index < response.length; index++) {
        //             // console.log(response[index].booking_type_name);
        //             $('[name="add_type"]').append('<option value=' + response[index].id + '>' +
        //                 response[index].title + '</option>');
        //         }
        //     }
        // });
    </script>
@endsection
