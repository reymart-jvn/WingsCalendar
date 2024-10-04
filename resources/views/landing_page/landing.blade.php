@extends('landing_page.app')
@section('css')
    <style>
        td.details-control {
            background: url('../assets/images/plus.png') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url('../assets/images/minus.png') no-repeat center center;
        }

        td.details-control {
            background: url('../assets/images/plus.png') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url('../assets/images/minus.png') no-repeat center center;
        }

        .container {
            margin: 0 !important;
            /* Remove all margins */
            padding: 0 !important;
            /* Optionally, remove padding as well */
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container">
            <div id="calendar">
            </div>
        </div>
    </div>

    <div class="modal fade" id="eventdetailsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body">
                </div>

            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/locale/ja.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>

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
                select: function(start, end, allDays) {
                    $('#eventdetailsModal').modal('toggle');
                },
                editable: true,
                eventDrop: function(event) {
                    var id = event.id;
                    var start_date = moment(event.start).format('YYYY-MM-DD');
                    var end_date = moment(event.end).format('YYYY-MM-DD');
                },
                eventClick: function(event) {},
                dayClick: function(date, allDay, jsEvent, view) {
                    // Get events for the clicked date
                    var eventsForDate = $('#calendar').fullCalendar('clientEvents', function(event) {
                        return event.start.format('YYYY-MM-DD') === date.format('YYYY-MM-DD');
                    });

                    var modalBody = $('#eventdetailsModal .modal-body');
                    modalBody.empty();
                    modalBody.append(
                        `<div class="card mb-3"><div class="card-body"><h4>Events for ${date.format('YYYY-MM-DD')}</h4></div></div>`
                    );

                    if (eventsForDate.length > 0) {
                        eventsForDate.forEach(function(event) {

                            var time = moment(event.time).format('h:mm A');
                            // Create a Bootstrap card for each event
                            var card = $('<div class="card mb-3">');
                            var cardBody = $('<div class="card-body">');

                            // Append event details to the card body
                            cardBody.append(`<h5 class="card-title">${event.title}</h5>`);
                            cardBody.append(
                                `<p class="card-text"><strong>Location:</strong> ${event.location}</p>`
                            );
                            cardBody.append(
                                `<p class="card-text"><strong>Address:</strong> ${event.address}</p>`
                            );
                            cardBody.append(
                                `<p class="card-text"><strong>Time:</strong> ${time}</p>`
                            );
                            cardBody.append(
                                `<p class="card-text"><strong>Incharge 1:</strong> ${event.incharge1}</p>`
                            );
                            cardBody.append(
                                `<p class="card-text"><strong>Incharge 2:</strong> ${event.incharge2}</p>`
                            );

                            // Append card body to the card
                            card.append(cardBody);

                            // Append card to the modal body
                            modalBody.append(card); // Add a horizontal line between events
                        });
                    } else {
                        modalBody.append(
                            '<div class="card mb-3"><div class="card-body"><p>No events for this date</p></div></div>'
                        );
                    }
                    // Show the modal
                    $('#eventdetailsModal').modal('show');
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



            $('.fc-event').css('font-size', '13px');
            $('.fc-event').css('width', '20px');
            $('.fc-event').css('border-radius', '50%');
            // Fetch events data using AJAX
            $.ajax({
                url: '/get-event-list', // Update the URL with your route
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    processObject.showProcessLoader();
                },
                success: function(response) {
                    if (response.success) {
                        // Parse event data and render on FullCalendar
                        console.log(response.data);
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

        });
    </script>
@endsection
