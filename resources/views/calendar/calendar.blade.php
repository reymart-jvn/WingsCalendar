<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/shuttlewiseicon.ico') }}">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
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
            background-image: rgb(85,34,195) !important;
            background-image: linear-gradient(0deg, rgba(85,34,195,1) 0%, rgba(251,216,255,1) 100%) !important;
            padding-top: 20px !important;
        }
    </style>
</head>


<body>

    <div class="container-scroller">


        <div class="modal fade" id="eventdetailsModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-body">
                    </div>

                </div>
            </div>
        </div>

        <div class="container-fluid page-body-wrapper full-page-wrapper">
      
            <div class="content-wrapper d-flex">
                <div class="container">
                   
                    <div class="card">
                        <div class="card-body">

                            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                                <a class="navbar-brand brand-logo" href="index.html">
                                    <img style="height: 70px !important ;width:70px !important" src="{{ asset('assets/images/logos/wings.png') }}" alt="logo" />
                                  </a> 
                            
                                    <ul >
                                      <li class="nav-item font-weight-semibold mt-3 d-lg-block">
                                        <h2>今日は, <span class="text-black fw-bold mb-0">{{ Auth::user()->name }}</span></h2>
                                        <h7 class="header-title">{{ getCompanyName() }}</h7>
                                        <br>
                                      </li>
                                    </ul>
                                
                                
                                <ul class="navbar-nav ms-auto">
                                    <form id="logout-form" method="POST" action="{{ route('logout') }}"
                                        style="display: none;">
                                        @csrf
                                        <img class="img-md rounded-circle" src="{{ asset('assets/images/face8.png') }}"
                                            alt="Profile image">
                                    </form>
                                    <a class="dropdown-item" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="dropdown-item-icon mdi mdi-power text-danger me-1" style="font-size: 3em;color: red;"></i>
                                        {{ __('') }}
                                    </a>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="card">
                        <div class="card-body">
                            <div id="calendar">
                            </div>
                        </div>
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



    @yield('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/locale/ja.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>

    <script>
        $(window).on('load', function() {
            setTimeout(function() {
                $("#fakeloader-overlay").fadeOut(300, function() {
                    $("#fakeloader-overlay").remove();
                });
            }, 100);
        });
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
</body>

</html>
