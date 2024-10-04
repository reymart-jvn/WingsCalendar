@extends('layouts.star-admin-app')
@section('css')
    <style>
        /* #barChart {
                                    height: 580px !important;
                                } */
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="home-tab">
                    <div class="d-sm-flex align-items-center justify-content-between border-bottom">

                    </div>
                    <div class="tab-content tab-content-basic">
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                            <div class="row">
                                <div class="col-lg-3 d-flex flex-column">
                                    <div class="row flex-grow">
                                        <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                                            <div class="card card-gradient">
                                                <div class="card-body">
                                                    <div class="circle-shadow-primary">
                                                        <i class="mdi mdi-chart-line" style="height:200px;width:200px"></i>
                                                    </div>
                                                    <h4>今年度のイベント合計</h4>
                                                    {{-- <p>+50% Income</p> --}}
                                                    <h1 class="text-primary" id="total_event_year"
                                                        name = "total_event_year">0</h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 d-flex flex-column">
                                    <div class="row flex-grow">
                                        <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                                            <div class="card card-gradient">
                                                <div class="card-body">
                                                    <div class="circle-shadow-primary">
                                                        <i class="mdi mdi-chart-line" style="height:200px;width:200px"></i>
                                                    </div>
                                                    <h4 id="month_now" name="month_now">今月のイベント合計</h4>
                                                    <h1 class="text-warning" id="total_event_month"
                                                        name = "total_event_month">0</h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 d-flex flex-column">
                                    <div class="row flex-grow">
                                        <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                                            <div class="card card-gradient">
                                                <div class="card-body">
                                                    <div class="circle-shadow-primary">
                                                        <i class="mdi mdi-chart-line" style="height:200px;width:200px"></i>
                                                    </div>
                                                    <h4>今週のイベント合計</h4>
                                                    <h1 class="text-success" id="total_event_week"
                                                        name = "total_event_week">0</h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 d-flex flex-column">
                                    <div class="row flex-grow">
                                        <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                                            <div class="card card-gradient">
                                                <div class="card-body">
                                                    <div class="circle-shadow-primary">
                                                        <i class="mdi mdi-chart-line" style="height:200px;width:200px"></i>
                                                    </div>
                                                    <h4>本日のイベント合計</h4>
                                                    <h1 class="text-info" id="total_event_today" name = "total_event_today">
                                                        0</h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-lg-5 grid-margin grid-margin-lg-0 stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-sm-flex justify-content-between align-items-start">
                                                <div>
                                                    <h4 class="card-title card-title-dash">担当者リスト</h4>
                                                </div>
                                                {{-- <div>
                                                    <button class="btn btn-primary btn-lg text-white mb-0 me-0"
                                                        type="button"><i class="mdi mdi-account-plus"></i>Add new
                                                        member</button>
                                                </div> --}}
                                            </div>
                                            <div class="table-responsive pt-3">
                                                <table class="table table-hover" id="table_id">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                コード
                                                            </th>
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

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-7 grid-margin grid-margin-lg-0 stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <div id="calendar">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            {{-- <div class="row flex-grow">
                                <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                                    <div class="card card-rounded">
                                        <div class="card-body">
                                            <div class="d-sm-flex justify-content-between align-items-start">
                                                <div>
                                                    <h4 class="card-title card-title-dash">Performance Line Chart</h4>
                                                    <h5 class="card-subtitle card-subtitle-dash">Lorem Ipsum is simply
                                                        dummy text of the printing</h5>
                                                </div>
                                                <div id="performance-line-legend">
                                                    <div class="chartjs-legend">
                                                        <ul>
                                                            <li><span style="background-color:#1F3BB3"></span>This week
                                                            </li>
                                                            <li><span style="background-color:#52CDFF"></span>Last week
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="chartjs-wrapper mt-4">
                                                <div class="chartjs-size-monitor">
                                                    <div class="chartjs-size-monitor-expand">
                                                        <div class=""></div>
                                                    </div>
                                                    <div class="chartjs-size-monitor-shrink">
                                                        <div class=""></div>
                                                    </div>
                                                </div>
                                                <canvas id="performaneLine"
                                                    style="display: block; width: 643px; height: 150px;" width="643"
                                                    height="150" class="chartjs-render-monitor"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/locale/ja.js"></script>
    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
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
                editable: true,
                eventDrop: function(event) {
                    var id = event.id;
                    var start_date = moment(event.start).format('YYYY-MM-DD');
                    var end_date = moment(event.end).format('YYYY-MM-DD');
                },
                eventClick: function(event) {},
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



                    console.log(formattedDates);

                    $('td[data-date="' + date.format() + '"]').toggleClass('fc-highlight');
                    // // Get events for the clicked date
                    // var eventsForDate = $('#calendar').fullCalendar('clientEvents', function(event) {
                    //     return event.start.format('YYYY-MM-DD') === date.format('YYYY-MM-DD');
                    // });

                    // var modalBody = $('#eventdetailsModal .modal-body');
                    // modalBody.empty();
                    // modalBody.append(
                    //     `<div class="card mb-3"><div class="card-body"><h4>Events for ${date.format('YYYY-MM-DD')}</h4></div></div>`
                    // );

                    // if (eventsForDate.length > 0) {
                    //     eventsForDate.forEach(function(event) {

                    //         var time = moment(event.time).format('h:mm A');
                    //         // Create a Bootstrap card for each event
                    //         var card = $('<div class="card mb-3">');
                    //         var cardBody = $('<div class="card-body">');

                    //         // Append event details to the card body
                    //         cardBody.append(`<h5 class="card-title">${event.title}</h5>`);
                    //         cardBody.append(
                    //             `<p class="card-text"><strong>Location:</strong> ${event.location}</p>`
                    //         );
                    //         cardBody.append(
                    //             `<p class="card-text"><strong>Address:</strong> ${event.address}</p>`
                    //         );
                    //         cardBody.append(
                    //             `<p class="card-text"><strong>Time:</strong> ${time}</p>`
                    //         );
                    //         cardBody.append(
                    //             `<p class="card-text"><strong>Incharge 1:</strong> ${event.incharge1}</p>`
                    //         );
                    //         cardBody.append(
                    //             `<p class="card-text"><strong>Incharge 2:</strong> ${event.incharge2}</p>`
                    //         );

                    //         // Append card body to the card
                    //         card.append(cardBody);

                    //         // Append card to the modal body
                    //         modalBody.append(card); // Add a horizontal line between events
                    //     });
                    // } else {
                    //     modalBody.append(
                    //         '<div class="card mb-3"><div class="card-body"><p>No events for this date</p></div></div>'
                    //     );
                    // }
                    // // Show the modal
                    // $('#eventdetailsModal').modal('show');
                },
                selectAllow: function(event) {
                    return moment(event.start).utcOffset(false).isSame(moment(event.end).subtract(1,
                        'second').utcOffset(false), 'day');
                },
                monthNames: ['いちがつ', 'にがつ', 'さんがつ', 'しがつ', 'ごがつ', 'ろくがつ', 'しちがつ', 'はちがつ', 'くがつ', 'じゅうがつ',
                    'じゅういちがつ', 'じゅうにがつ'
                ],
                dayNames: ['月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日', '日曜日'],
                locale: 'ja', // Set the language to Japanese
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

        let table = new DataTable('#table_id', {
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
            "columns": [{
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

        $.ajax({
            url: '/get-total-event-schedule', // Update the URL with your route
            type: 'GET',
            dataType: 'json',
            beforeSend: function() {
                processObject.showProcessLoader();
            },
            success: function(response) {
                if (response.success) {

                    $('#total_event_year').text(response.year);
                    $('#total_event_month').text(response.month);
                    $('#total_event_week').text(response.week);
                    $('#total_event_today').text(response.today);
                    var currentDate = new Date();

                    // Get the month name using toLocaleString
                    var currentMonthName = currentDate.toLocaleString('default', {
                        month: 'long'
                    });

                    var currentMonthNumber = currentDate.getMonth() + 1;

                    var monthNames = ['いちがつ', 'にがつ', 'さんがつ', 'しがつ', 'ごがつ', 'ろくがつ', 'しちがつ', 'はちがつ', 'くがつ',
                        'じゅうがつ',
                        'じゅういちがつ', 'じゅうにがつ'
                    ];
                    $('#month_now').text("今月のイベント合計 " + monthNames[currentMonthNumber]);
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
    </script>
@endsection
