@extends('layouts.star-admin-app')
@section('css')
    <style>
        .flex-container {
            display: flex;
            justify-content: center;
        }

        .qr-code {
            width: 128px;
            height: 128px;
            margin-right: 20px;
        }

        td.details-control {
            background: url('../assets/images/plus.png') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url('../assets/images/minus.png') no-repeat center center;
        }

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

                        {{-- @if (Gate::allows('permission', 'createPassenger'))
                            <button type="button" onclick="showModalAdd()" class="btn btn-success btn-icon-tex">Add New
                                Passenger</button>
                        @endif --}}
                        {{-- 
                        <div>
                            <button type="button" onclick="generateQR()" class="btn btn-info btn-icon-text">Generate QR
                                Code</button>
                            <button type="button" onclick="importCSV()" class="btn btn-warning btn-icon-text">Import
                                CSV</button>
                            <a href="{{ asset('assets/csv_format/PASSENGER_CSV_FORMAT_FINAL.csv') }}" download>
                                <button class="btn btn-primary btn-icon-text">Download CSV Format</button>
                            </a>

                            @if (Gate::allows('permission', 'createPassenger'))
                                <button type="button" onclick="showModalAdd()" class="btn btn-success btn-icon-tex">Add New
                                    Passenger</button>
                            @endif
                        </div> --}}
                    </h4>

                    <p class="card-description">
                        {{ $label }}
                    </p>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="selectpicker form-control" id="reports_company" name="reports_company">
                                    <option value="" disabled selected>Select Company</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="selectpicker form-control" id="reports_section" name="reports_section">
                                    <option value="" disabled selected>Select Section</option>
                                    <option value="ALL">ALL</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <!-- Barangay -->
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <span class="mdi mdi-calendar-plus"></span>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="reports_date_from"
                                        name="reports_date_from" placeholder="Date From">
                                </div>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <!-- Barangay -->
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <span class="mdi mdi-calendar-plus"></span>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="reports_date_to" name="reports_date_to"
                                        placeholder="Date To">

                                </div>

                            </div>
                        </div>

                    </div>
                    <div>
                        <button onclick="generateExcelPerSection()" class="btn btn-block btn-sm btn-primary">Generate
                            Excel</button>
                        <button onclick="" class="btn btn-sm btn-warning">Reset</button>
                    </div>
                    <hr>
                    <br>
                    <div class="table-responsive pt-3">
                        <table class="table table-hover" id="table_id">
                            <thead>
                                <tr>
                                    {{-- <th class="text-center">#</th> --}}
                                    <th>
                                        Passenger Code
                                    </th>
                                    <th>
                                        Section
                                    </th>
                                    <th>
                                        Employee Number
                                    </th>
                                    <th>
                                        Fullname
                                    </th>
                                    <th>
                                        Company
                                    </th>
                                    {{-- <th>
                                        Sex
                                    </th>
                                    <th>
                                        Date of Birth
                                    </th> --}}
                                    <th>
                                        Status
                                    </th>
                                    <th @if (Gate::allows('permission', 'updatePassenger') || Gate::allows('permission', 'deletePassenger')) style="width: 200px;" @endif style="width: 0px;">
                                        @if (Gate::allows('permission', 'updatePassenger') || Gate::allows('permission', 'deletePassenger'))
                                            Action
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



    <div class="modal fade" id="print_modal" tabindex="-1" role="dialog" aria-labelledby="print_label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="print_label">Add Vehicle Type</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Barangay -->
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"> <span class="mdi mdi-calendar-plus"></span>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="date_from" name="date_from"
                                                placeholder="Date From">
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Barangay -->
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"> <span class="mdi mdi-calendar-plus"></span>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="date_to" name="date_to"
                                                placeholder="Date To">

                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div>
                                <button onclick="filterLogs()" class="btn btn-block btn-sm btn-primary">Filter</button>
                                <button onclick="resetLogs()" class="btn btn-sm btn-warning">Reset</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <input type="hidden" id="passenger_id" name="passenger_id">

                    <form id="print_forms">
                        <div class="table-responsive w-100">
                            <table style="width:100%">
                                <tbody>
                                    {{-- <tr>
                                        <td colspan="8">
                                    <tr>
                                        <td colspan="8" style="font-size:20px;font-weight: bold">
                                            <center>JVN TRANSPORT SERVICES</center>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" style="margin-bottom: 20px">
                                            <center>Purok 3, San Antonio, Bay 4033,Laguna, Philippines <br>
                                                <hr>
                                        </td>
                                    </tr> --}}

                                    <tr style="font-size:16px">

                                        <td colspan="4" style="margin-bottom: 20px;font-size:16px">

                                            EMPLOYEE NAME: <span id="employee_name" style="font-weight:bold">JUAN DELA
                                                CRUZ</span><br>
                                            EMPLOYEE NUMBER: <span id="employee_number"
                                                style="font-weight:bold">EMP00000000</span><br>
                                            DATE FROM: <span id="date_range_from"
                                                style="font-weight:bold">EMP00000000</span>
                                            <br>
                                            DATE TO: <span id="date_range_to" style="font-weight:bold">EMP00000000</span>
                                            <br>

                                        </td>
                                        <td colspan="4" style="margin-bottom: 20px">
                                            <div id="print_qrcode"></div>
                                            <br>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table" id="table_print_billing" style="width:100%">
                                <thead style="text-align: left;font-size:10px;background-color:black;color:white;">
                                    <tr style="padding-left: 10px">
                                        <th style="width:10%;">
                                            DATE
                                        </th>
                                        <th style="width:10%;">
                                            SECTION
                                        </th>
                                        <th style="width:10%">
                                            PLATE NUMBER
                                        </th>
                                        <th style="width:15%">
                                            DRIVER
                                        </th>
                                        <th style="width:15%;">
                                            ROUTE
                                        </th>
                                        <th style="width:5%;">
                                            LOGS
                                        </th>
                                        <th style="width:3%;">
                                            TRANSFEREE
                                        </th>

                                    </tr>
                                </thead>
                                <tbody style="font-size:10px">


                                </tbody>
                                {{-- <tfoot style="font-size:10px">
                                <tr>
                                    <th colspan="6" style="text-align: right;">GRAND TOTAL:</th>
                                    <th style="text-align: left">400,000.00</th>
                                </tr>
                            </tfoot> --}}
                            </table>

                        </div>
                        <hr>
                        {{-- <br>
                        <br>
                        <br>
                        <br>
                        <br> --}}

                        {{-- <table style="width:100%;font-size:80%">
                            <thead>
                                <tr>
                                    <td style="text-align: center" colspan="3">Prepared By: <br><br>
                                        ____________________________ <br>Secretary / Date</td>

                                    <td style="text-align: center" colspan="3">Approved By: <br><br>
                                        ____________________________ <br>President / Date</td>
                                    <td></td>
                                </tr>
                            </thead>
                        </table> --}}
                </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" onclick="printAttendance()" class="btn btn-primary">Print</button>
                    <button type="button" onclick="generateExcel()" class="btn btn-success">Excel</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="generate_modal" tabindex="-1" role="dialog" aria-labelledby="generate_label"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="forms-sample" id="generate_forms" method="POST">
                        @csrf
                        @method('POST')


                        <div class="card-body">
                            <div class="table-responsive w-100">
                                <table style="width:100%;font-size:80%" id="qrcode_passenger_table">
                                    {{-- <tbody>
                                        <tr>
                                            <td>
                                                <div id="qrcode-container" name="qrcode-container"></div>
                                                <p id="passenger_name"></p>
                                            </td>


                                        </tr>
                                    </tbody> --}}

                                </table>
                            </div>


                            {{-- <div class="col-md-12">
                                <div id="qrcode-container" name="qrcode-container" class="flex-container"></div>
                                <p id="passenger_name"></p>
                                <br>
                            </div> --}}

                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" onclick="print()" class="btn btn-primary"><i
                            class="ti-printer me-1"></i>Print</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/JavaScript" src="{{ asset('assets/js/easy.qrcode.min.js') }}"></script>
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    {{-- <script src="{{ asset('assets/js/ph_address.js') }}"></script> --}}
    {{-- <script>
        $(function() {
            // $('#add_date_of_birth[]').datepicker();
            $('#update_date_of_birth').datepicker();
            $('#add_date_of_birth').datepicker();
        });
    </script> --}}
    <script>
        var add_first_name = [];
        let counter = 1;

        $(function() {
            $("#date_from").datepicker({
                "dateFormat": "Y-m-d"
            });
            $("#date_to").datepicker({
                "dateFormat": "Y-m-d"
            });
            $("#reports_date_from").datepicker({
                "dateFormat": "Y-m-d"
            });
            $("#reports_date_to").datepicker({
                "dateFormat": "Y-m-d"
            });
        });

        const printAttendance = () => {
            Swal.fire({
                title: 'Do you want to print?',
                icon: 'warning',
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Print it!'
            }).then((result) => {
                if (result.value) {
                    table.ajax.reload(null, false);

                    // var qr = qrcode(0, 'L');
                    // qr.addData(qr_code);
                    // qr.make();
                    // document.getElementById('print_qrcode').innerHTML = qr.createImgTag();

                    printJS({
                        printable: 'print_forms',
                        type: 'html',
                    });

                    $('#table_print_billing tbody').empty();

                }
            });
        }

        const filterLogs = () => {
            $('#table_print_billing tbody').empty();
            let from = $("#date_from").val();
            let to = $("#date_to").val();
            let passenger = $("#passenger_id").val();

            $("#date_range_from").text($("#date_from").val());
            $("#date_range_to").text($("#date_to").val());

            from = from.split('/');
            const year = from[2];
            const month = from[0].padStart(2, '0');
            const day = from[1].padStart(2, '0');
            from = `${year}-${month}-${day}`;

            to = to.split('/');
            const year1 = to[2];
            const month1 = to[0].padStart(2, '0');
            const day1 = to[1].padStart(2, '0');
            to = `${year1}-${month1}-${day1}`;

            $.ajax({
                url: "/get-attendance-by-passenger-id/" + passenger + "/" + from + "/" + to,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log(response.attendance);
                    var prevDate = null;

                    response.attendance.sort(function(a, b) {
                        // var plateNumberA = a.vehicle.certificate_of_registration.plate_number;
                        // var plateNumberB = b.vehicle.certificate_of_registration.plate_number;

                     
                            var dateA = new Date(a.booking_info.departure_date + " " + a
                                .booking_info.departure_time);
                            var dateB = new Date(b.booking_info.departure_date + " " + b
                                .booking_info.departure_time);
                            return dateA - dateB;
                        
                    });

                    if (response.attendance.length != 0) {
                        for (let index = 0; index < response.attendance.length; index++) {
                            let origin_city = response.attendance[index].booking_info.origin;
                            const city_origin = origin_city.split(",");
                            let destination_city = response.attendance[index].booking_info.destination;
                            const city_destination = destination_city.split(",");

                            const dateString = response.attendance[index].logs;
                            const date = new Date(dateString);
                            const departure_date = new Date(response.attendance[index].booking_info
                                .departure_date);
                            const options = {
                                hour: 'numeric',
                                minute: 'numeric',
                                hour12: true
                            };

                            const optionsDepartureDate = {
                                month: 'long',
                                day: 'numeric',
                                year: 'numeric',
                            };

                            const formattedDate = date.toLocaleTimeString('en-US', options).toUpperCase();
                            var formattedDepartureDate = departure_date.toLocaleDateString('en-US',
                                optionsDepartureDate).toUpperCase();

                            //     formattedDepartureDate,
                            // response.passenger.section.name,
                            // response.attendance[index].booking_info.booking_has_vehicle_driver.vehicle.certificate_of_registration.plate_number,
                            // response.attendance[index].booking_info.booking_has_vehicle_driver.driver.first_name + " " + response.attendance[index].booking_info.booking_has_vehicle_driver.driver.last_name,
                            // city_origin[2] + " - " + city_destination[2],
                            // response.attendance[index].logs == null || response.attendance[index].logs == "" ? "-" : formattedDate,
                            // response.attendance[index].transferee == "0" ? "NO" : response.attendance[
                            //     index].transferee == null ? "NO" : "YES"

                            if (prevDate == formattedDepartureDate) {
                                formattedDepartureDate = "";
                            } else {
                                prevDate = formattedDepartureDate;
                            }

                            $('#table_print_billing tbody').append(`
                <tr>
                            <td>${ formattedDepartureDate}</td>
                            <td>${ response.passenger.section.name }</td>
                        
                            <td>${ response.attendance[index].booking_info.booking_has_vehicle_driver.vehicle.certificate_of_registration.plate_number}</td>
                            <td>${ response.attendance[index].booking_info.booking_has_vehicle_driver.driver.first_name + " " + response.attendance[index].booking_info.booking_has_vehicle_driver.driver.last_name}</td>
                            <td>${  city_origin[3] + " - " + city_destination[3]} </td>
                            <td>${  response.attendance[index].logs == null || response.attendance[index].logs == "" ? "-" : formattedDate} </td>
                            <td>${ response.attendance[index].transferee == null ? '<span class="badge badge-opacity-success me-3">NO</span>' : response.attendance[index].transferee == "0" ?  '<span class="badge badge-opacity-success me-3">NO</span>' : '<span class="badge badge-opacity-danger me-3">YES</span>' } </td>
                          </tr>
                `);
                        }
                    } else {
                        $('#table_print_billing tbody').append(`
                <tr>
                
                            <td colspan="5" style="text-align:center">NO DATA FOUND</td>
                            </tr>
                `);
                    }



                }
            });
        }

        const viewAttendance = (id, firstname, lastname, empnumber) => {
            $('#table_print_billing tbody').empty();
            $("#print_modal").find(".modal-header > h5").text("Passenger Trip Logs").end()
                .modal('show');

            $("#employee_name").text(firstname.toUpperCase() + " " + lastname.toUpperCase());
            $("#employee_number").text(empnumber);
            $("#date_range_from").text("-");
            $("#date_range_to").text("-");
            $("#passenger_id").val(id);

            // $.ajax({
            //     url: "/get-attendance-by-passenger-id/" + id,
            //     type: 'GET',
            //     dataType: 'json',
            //     success: function(response) {
            //         console.log(response.attendance);
            //         $("#employee_name").text(response.passenger.firstname+" "+response.passenger.lastname);
            //         $("#employee_number").text(response.passenger.employee_number);
            //         for (let index = 0; index < response.attendance.length; index++) {

            //             let origin_city = response.attendance[index].booking_info.origin;
            //             const city_origin = origin_city.split(",");
            //             let destination_city = response.attendance[index].booking_info.destination;
            //             const city_destination = destination_city.split(",");

            //             const dateString = response.attendance[index].updated_at;
            //             const date = new Date(dateString);

            //             const options = { month: 'long', day: 'numeric', year: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true };
            //             const formattedDate = date.toLocaleDateString('en-US', options).toUpperCase();

            //             $('#table_print_billing tbody').append(`
        //     <tr>

        //                 <td>${ formattedDate}</td>
        //                 <td>${ response.attendance[index].pick_up_point}</td>
        //                 <td>${ city_origin[2] + " - " + city_destination[2]}</td>
        //                 <td>${ response.attendance[index].travel_status == "FOR APPROVAL" ? '' :  response.attendance[index].travel_status == "WAITING" ? '<span class="badge badge-danger me-3">ABSENT</span>' :  response.attendance[index].travel_status == "ONGOING" ? '<span class="badge badge-opacity-success me-3">PRESENT</span>' :  response.attendance[index].travel_status == "DONE" ?  '<span class="badge badge-opacity-success me-3">PRESENT</span>' : '<span class="badge badge-opacity-danger me-3">DECLINED</span>' } </td>

        //               </tr>
        //     `);
            //         }


            //     }
            // });
        }

        function getMonthAbbreviation(monthIndex) {
            var date = new Date();
            date.setMonth(monthIndex);

            var monthAbbreviation = date.toLocaleString('default', {
                month: 'short'
            }).toUpperCase();

            return monthAbbreviation;
        }
        const generateExcel = () => {
            // Create a new workbook
            let from = $("#date_from").val();
            let to = $("#date_to").val();
            let passenger = $("#passenger_id").val();

            from = from.split('/');
            const year = from[2];
            const month = from[0].padStart(2, '0');
            const day = from[1].padStart(2, '0');
            from = `${year}-${month}-${day}`;

            to = to.split('/');
            const year1 = to[2];
            const month1 = to[0].padStart(2, '0');
            const day1 = to[1].padStart(2, '0');
            to = `${year1}-${month1}-${day1}`;


            var workbook = XLSX.utils.book_new();
            var startRow = 4;

            var worksheetMain = XLSX.utils.aoa_to_sheet([
                ['EMPLOYEE NAME:', $("#employee_name").text().toUpperCase(), '', '', '', '', ''],
            ]);
            var worksheetCompany = ['EMPLOYEE NUMBER:', $("#employee_number").text(), '', '', '', '', ''];
            XLSX.utils.sheet_add_aoa(worksheetMain, [worksheetCompany], {
                origin: -1,
            });

            var dateFrom = ['DATE FROM:', $("#date_from").val(), '', '', '', '', ''];
            XLSX.utils.sheet_add_aoa(worksheetMain, [dateFrom], {
                origin: -1,
            });

            var dateTo = ['DATE TO:', $("#date_to").val(), '', '', '', '', ''];
            XLSX.utils.sheet_add_aoa(worksheetMain, [dateTo], {
                origin: -1,
            });

            var worksheetData = ['DATE', 'SECTION', 'PLATE NUMBER', 'DRIVER', 'ROUTE', 'LOGS', 'TRANSFEREE'];
            XLSX.utils.sheet_add_aoa(worksheetMain, [worksheetData], {
                origin: -1,
            });



            // var worksheet = XLSX.utils.aoa_to_sheet([
            //     ['VAN #', 'PLATE #', 'DRIVER', 'ROUTE', 'PASSENGER', 'DEPARTURE - ARRIVAL', 'COST PER TRIP'],
            // ]);

            var fromDateFormatted = getMonthAbbreviation(month - 1) + day + year;
            var toDateFormatted = getMonthAbbreviation(month1 - 1) + day1 + year1;
            console.log(toDateFormatted);
            var grandTotal = 0;
            $.ajax({
                url: "/get-attendance-by-passenger-id/" + passenger + "/" + from + "/" + to,
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    processObject.showProcessLoader();
                },
                success: function(response) {
                    console.log(response.passenger);
                    console.log(response.attendance);

                    var prevDate = null;
                    for (let index = 0; index < response.attendance.length; index++) {

                        let origin_city = response.attendance[index].booking_info.origin;
                        const city_origin = origin_city.split(",");
                        let destination_city = response.attendance[index].booking_info.destination;
                        const city_destination = destination_city.split(",");


                        const dateString = response.attendance[index].logs;
                        const date = new Date(dateString);

                        const options = {

                            hour: 'numeric',
                            minute: 'numeric',
                            hour12: true
                        };
                        const formattedDate = date.toLocaleTimeString('en-US', options).toUpperCase();

                        const departure_date = new Date(response.attendance[index].booking_info
                            .departure_date);

                        const optionsDepartureDate = {
                            month: 'long',
                            day: 'numeric',
                            year: 'numeric',
                        };
                        const formattedDepartureDate = departure_date.toLocaleDateString('en-US',
                            optionsDepartureDate).toUpperCase();



                        var row = [
                            formattedDepartureDate,
                            response.passenger.section.name,
                            response.attendance[index].booking_info.booking_has_vehicle_driver.vehicle
                            .certificate_of_registration.plate_number,
                            response.attendance[index].booking_info.booking_has_vehicle_driver.driver
                            .first_name + " " + response.attendance[index].booking_info
                            .booking_has_vehicle_driver.driver.last_name,
                            city_origin[2] + " - " + city_destination[2],
                            response.attendance[index].logs == null || response.attendance[index]
                            .logs == "" ? "-" : formattedDate,
                            response.attendance[index].transferee == "0" ? "NO" : response.attendance[
                                index].transferee == null ? "NO" : "YES"

                        ];

                        // Blank the cell if the plate number is the same as the previous row
                        if (prevDate === formattedDepartureDate) {
                            row[0] = {
                                v: "",
                                s: {}
                            }; // Set the cell value to an empty string
                        } else {
                            prevDate = formattedDepartureDate; // Update the previous plate number
                        }

                        var rowIndex = startRow + index;
                        XLSX.utils.sheet_add_aoa(worksheetMain, [row], {
                            origin: -1,
                        });


                    }


                    XLSX.utils.book_append_sheet(workbook, worksheetMain, fromDateFormatted + "-" +
                        toDateFormatted);

                    // Generate the Excel file
                    var excelBuffer = XLSX.write(workbook, {
                        bookType: 'xlsx',
                        type: 'array'
                    });

                    // Convert the array buffer to a Blob
                    var blob = new Blob([excelBuffer], {
                        type: 'application/octet-stream'
                    });

                    // Create a download link and trigger the download
                    var downloadLink = document.createElement('a');
                    downloadLink.href = window.URL.createObjectURL(blob);
                    downloadLink.download = $("#employee_name").text().toUpperCase() + "[" + $(
                        "#employee_number").text() + "]" + '.xlsx';
                    downloadLink.click();

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

            // Create a worksheet

        }

        const generateExcelPerSection = () => {
            // Create a new workbook
            let from = $("#reports_date_from").val();
            let to = $("#reports_date_to").val();
            let section = $("#reports_section").val();
            let company = $("#reports_company").val();

            from = from.split('/');
            const year = from[2];
            const month = from[0].padStart(2, '0');
            const day = from[1].padStart(2, '0');
            from = `${year}-${month}-${day}`;

            to = to.split('/');
            const year1 = to[2];
            const month1 = to[0].padStart(2, '0');
            const day1 = to[1].padStart(2, '0');
            to = `${year1}-${month1}-${day1}`;


            var workbook = XLSX.utils.book_new();
            var startRow = 0;



            // var worksheet = XLSX.utils.aoa_to_sheet([
            //     ['VAN #', 'PLATE #', 'DRIVER', 'ROUTE', 'PASSENGER', 'DEPARTURE - ARRIVAL', 'COST PER TRIP'],
            // ]);

            var fromDateFormatted = getMonthAbbreviation(month - 1) + day + year;
            var toDateFormatted = getMonthAbbreviation(month1 - 1) + day1 + year1;
            // console.log(toDateFormatted);
            // var grandTotal = 0;
            $.ajax({
                url: "/get-logs-report-per-section/" + section + "/" + company + "/" + from + "/" + to,
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    processObject.showProcessLoader();
                },
                success: function(response) {
                    console.log(response.section);
                    // console.log(response.attendance);

                    var prevDate = null;

                    response.section.sort(function(a, b) {
                        // var plateNumberA = a.vehicle.certificate_of_registration.plate_number;
                        // var plateNumberB = b.vehicle.certificate_of_registration.plate_number;

                     
                            var dateA = new Date(a.booking_info.departure_date + " " + a
                                .booking_info.departure_time);
                            var dateB = new Date(b.booking_info.departure_date + " " + b
                                .booking_info.departure_time);
                            return dateA - dateB;
                        
                    });
                    for (let index = 0; index < response.section.length; index++) {


                        var sheetName = response.section[index].passenger_information.firstname + " " +
                            response.section[index].passenger_information.lastname;
                        if (workbook.SheetNames.includes(sheetName)) {
                            var currentSheet = workbook.Sheets[sheetName];
                        } else {
                            // Create a new sheet for the current plate number
                            var currentSheet = XLSX.utils.aoa_to_sheet([]);
                            workbook.SheetNames.push(sheetName);
                            workbook.Sheets[sheetName] = currentSheet;

                            var worksheetMain = ['EMPLOYEE NAME:', (response.section[index]
                                    .passenger_information.firstname).toUpperCase() + " " +
                                (response.section[index].passenger_information.lastname).toUpperCase(),
                                '', '', '', '', ''
                            ];
                            XLSX.utils.sheet_add_aoa(currentSheet, [worksheetMain], {
                                origin: -1,
                            });
                            startRow++;
                            var worksheetMain2 = ['EMPLOYEE NUMBER:', response.section[index]
                                .passenger_information.employee_number, '', '', '', '', ''
                            ];
                            XLSX.utils.sheet_add_aoa(currentSheet, [worksheetMain2], {
                                origin: -1,
                            });
                            startRow++;
                            var worksheetMain3 = ['DATE FROM:', $("#reports_date_from").val(), '', '', '',
                                '', ''
                            ];
                            XLSX.utils.sheet_add_aoa(currentSheet, [worksheetMain3], {
                                origin: -1,
                            });
                            startRow++;
                            var worksheetMain4 = ['DATE TO:', $("#reports_date_to").val(), '', '', '', '',
                                ''
                            ];
                            XLSX.utils.sheet_add_aoa(currentSheet, [worksheetMain4], {
                                origin: -1,
                            });
                            startRow++;
                            var worksheetMain5 = ['', '', '', '', '', '', ''];
                            XLSX.utils.sheet_add_aoa(currentSheet, [worksheetMain5], {
                                origin: -1,
                            });
                            startRow++;
                            // Add header row to the new sheet
                            var headerRow = ['DATE', 'PLATE NUMBER', 'DRIVER', 'ROUTE', 'LOGS',
                                'TRANSFEREE'
                            ];
                            XLSX.utils.sheet_add_aoa(currentSheet, [headerRow], {
                                origin: -1,
                            });
                            startRow++;
                        }


                        let origin_city = response.section[index].booking_info.origin;
                        const city_origin = origin_city.split(",");
                        let destination_city = response.section[index].booking_info.destination;
                        const city_destination = destination_city.split(",");

                        const dateString = response.section[index].logs;
                        const date = new Date(dateString);

                        const options = {

                            hour: 'numeric',
                            minute: 'numeric',
                            hour12: true
                        };
                        const formattedDate = date.toLocaleTimeString('en-US', options).toUpperCase();

                        const departure_date = new Date(response.section[index].booking_info
                            .departure_date);

                        const optionsDepartureDate = {
                            month: 'long',
                            day: 'numeric',
                            year: 'numeric',
                        };
                        const formattedDepartureDate = departure_date.toLocaleDateString('en-US',
                            optionsDepartureDate).toUpperCase();

                        var row = [
                            formattedDepartureDate,
                            response.section[index].booking_info.booking_has_vehicle_driver.vehicle
                            .certificate_of_registration.plate_number,
                            response.section[index].booking_info.booking_has_vehicle_driver.driver
                            .first_name + " " + response.section[index].booking_info
                            .booking_has_vehicle_driver.driver.last_name,
                            city_origin[2] + " - " + city_destination[2],
                            response.section[index].logs == null || response.section[index].logs == "" ?
                            "-" : formattedDate,
                            response.section[index].transferee == "0" ? "NO" : response.section[
                                index].transferee == null ? "NO" : "YES"

                        ];


                        XLSX.utils.sheet_add_aoa(currentSheet, [row], {
                            origin: -1,
                        });
                        startRow++;

                        // Blank the cell if the plate number is the same as the previous row
                        if (prevDate === formattedDepartureDate) {
                            row[0] = ""; // Set the cell value to an empty string
                        } else {
                            prevDate = formattedDepartureDate; // Update the previous plate number
                        }

                        var rowIndex = startRow + index;
                        XLSX.utils.sheet_add_aoa(worksheetMain, [row], {
                            origin: -1,
                        });


                    }


                    // XLSX.utils.book_append_sheet(workbook, worksheetMain,  response.section[index].passenger_information  fromDateFormatted + "-" +
                    //     toDateFormatted);

                    // // Generate the Excel file
                    var excelBuffer = XLSX.write(workbook, {
                        bookType: 'xlsx',
                        type: 'array'
                    });

                    // // Convert the array buffer to a Blob
                    var blob = new Blob([excelBuffer], {
                        type: 'application/octet-stream'
                    });

                    // // Create a download link and trigger the download
                    var downloadLink = document.createElement('a');
                    downloadLink.href = window.URL.createObjectURL(blob);
                    downloadLink.download = (section == "ALL" ? "PASSENGER LOGS " : response.section[0].passenger_information.section.name) + " (" +
                        fromDateFormatted + "-" + toDateFormatted + ") " + '.xlsx';
                    downloadLink.click();

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

            // Create a worksheet

        }

        $.ajax({
            url: '{{ route('get-all-company') }}',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log(response);
                for (let index = 0; index < response.length; index++) {
                    // console.log(response[index].vehicle_type_name);
                    $('[name="reports_company"]').append('<option value=' + response[index].id + '>' +
                        response[index].company_name + '</option>');
                    // $('.selectpicker').selectpicker('refresh');
                }

            }
        });

        $.ajax({
            url: '{{ route('get-all-section') }}',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log(response);
                for (let index = 0; index < response.length; index++) {
                    // console.log(response[index].vehicle_type_name);
                    $('[name="reports_section"]').append('<option value=' + response[index].id + '>' +
                        response[index].name + '</option>');
                    // $('.selectpicker').selectpicker('refresh');
                }

            }
        });

        $('#tbl_add_passenger tbody').on("click", "#remove_field", function(e) {
            counter--;
            e.preventDefault();
            $(this).parent().parent().remove();
            ctr--;
        });

        $('#choose_by').on("click", function(e) {
            if ($('#choose_by').val() == '2') {
                $('#add_group_name').attr("disabled", false);
            } else {
                $('#add_group_name').attr("disabled", true);
            }
        });

        $('#add_company_name').on("click", function(e) {
            var value = $("#add_company_name option:selected");

            $('#add_company').val(value.text());

        });



        //DATA TABLE FOR DRIVERS LIST
        let table = new DataTable('#table_id', {
            "processing": true,
            "serverSide": true,
            "language": {
                "sSearch": "Search Employee Number, Section, Name:"
            },
            "ajax": {
                "url": '{{ route('get-passenger-reports') }}',
                "dataType": "json",
                "type": "GET",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columns": [
                // {
                //     "className": 'details-control',
                //     "orderable": false,
                //     "data": null,
                //     "defaultContent": ''
                // }, 
                {
                    "data": "passenger_code"
                },
                {
                    "data": "section"
                },
                {
                    "data": "employee_number"
                },
                {
                    "data": "fullname"
                },
                {
                    "data": "company"
                },
                // {
                //     "data": "sex"
                // },
                // {
                //     "data": "dob"
                // },
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

        // $('#table_id tbody').on('click', 'td.details-control', function() {
        //     let summary_datatable = $('#table_id').DataTable();
        //     var tr = $(this).closest('tr');
        //     var row = summary_datatable.row(tr);

        //     if (row.child.isShown()) {
        //         // This row is already open - close it
        //         row.child.hide();
        //         tr.removeClass('shown');
        //     } else {
        //         // Open this row
        //         row.child(format(row.data())).show();
        //         tr.addClass('shown');
        //     }
        // });

        // function format(d) {
        //     var data = d.arr;
        //     var data_book = d.arr_route
        //     // console.log(data);
        //     var output = "";
        //     var amData = [];
        //     var pmData = [];
        //     var amTimeScanned = [];
        //     var pmTimeScanned = [];

        //     output += `<br><h5>LOGS</h5><br><div class="col-md-12">
    //             <table class="table table-bordered table-hover">
    //                 <thead>
    //                     <th style="width: 20%;">Date</th>
    //                     <th style="width: 20%;">AM Time</th>
    //                     <th style="width: 20%;">PM Time</th>
    //                     <th style="width: 30%;">Route</th>
    //                     <th style="width: 10%;">Logs Status</th>
    //                     <th style="width: 10%;">Transferee</th>
    //                 </thead>
    //                 <tbody>`;
        //     if (data.length > 0) {
        //         for (let index = 0; index < data.length; index++) {
        //             let origin_city = data[index].booking_info.origin;
        //             const city_origin = origin_city.split(",");
        //             let destination_city = data[index].booking_info.destination;
        //             const city_destination = destination_city.split(",");
        //             let formattedTimestamp = "-";
        //             let formattedTimestampPM = "-";
        //             let formattedDepartureDate = "-";
        //             let dapartureDate = new Date(data[index].booking_info.departure_date);

        //             if (data[index].in_out == "1") {
        //                 amData.push(data[index]);
        //             } else {
        //                 pmData.push(data[index]);
        //             }
        //         }

        //         console.log(amData);
        //         console.log(pmData);


        //         for (let index0 = 0; index0 < amData.length; index0++) {
        //             let origin_city = amData[index0].booking_info.origin;
        //             const city_origin = origin_city.split(",");
        //             let destination_city = amData[index0].booking_info.destination;
        //             const city_destination = destination_city.split(",");
        //             let formattedTimestamp = "-";
        //             let formattedTimestampPM = "-";
        //             let formattedDepartureDate = "-";
        //             let dapartureDate = new Date(amData[index0].booking_info.departure_date);

        //             if (amData[index0].logs != null) {

        //                 let timestamp = new Date(amData[index0].logs);

        //                 let options = {
        //                     // month: 'long',
        //                     // day: 'numeric',
        //                     // year: 'numeric',
        //                     hour: 'numeric',
        //                     minute: 'numeric',
        //                     hour12: true
        //                 };

        //                 formattedTimestamp = timestamp.toLocaleString('en-US', options).toUpperCase();

        //             }

        //             let optionsDeparture = {
        //                 month: 'long',
        //                 day: 'numeric',
        //                 year: 'numeric'
        //             };
        //             formattedDepartureDate = dapartureDate.toLocaleString('en-US', optionsDeparture).toUpperCase();

        //             for (let index1 = 0; index1 < pmData.length; index1++) {


        //                 if ((pmData[index1].booking_info.departure_date == amData[index0].booking_info
        //                         .departure_date) && (pmData[index1].passenger_info_id == amData[
        //                         index0].passenger_info_id)) {
        //                     if (pmData[index1].logs != null) {
        //                         let timestampPM = new Date(pmData[index1].logs);
        //                         let optionsPM = {
        //                             // month: 'long',
        //                             // day: 'numeric',
        //                             // year: 'numeric',
        //                             hour: 'numeric',
        //                             minute: 'numeric',
        //                             hour12: true
        //                         };
        //                         formattedTimestampPM = timestampPM.toLocaleString('en-US', optionsPM).toUpperCase();
        //                     }
        //                     else
        //                     {
        //                         formattedTimestampPM = "-";
        //                     }

        //                 } else {
        //                     console.log("here");

        //                 }



        //             }

        //             output += `<tr>
    //                     <td>${formattedDepartureDate}</td>
    //                     <td>${formattedTimestamp}</td>
    //                     <td>${formattedTimestampPM}</td>
    //                     <td>${ city_origin[2] + " - " + city_destination[2]}</td>

    //                     <td>${(amData[index0].logs != null || formattedTimestampPM != "-") ? '<span class="badge badge-opacity-success me-3">PRESENT</span>' : '<span class="badge badge-opacity-danger me-3">ABSENT</span>' } </td>
    //                     <td>${amData[index0].transferee == null ? '<span class="badge badge-opacity-success me-3">NO</span>' : amData[index0].transferee == "0" ?  '<span class="badge badge-opacity-success me-3">NO</span>' : '<span class="badge badge-opacity-danger me-3">YES</span>' } </td>
    //                 </tr>`;

        //             // if(pmData.length > amData.length)
        //             // {
        //             //     output += `<tr>
    //         //         <td>${formattedDepartureDate}</td>
    //         //         <td>${formattedTimestamp}</td>
    //         //         <td>${formattedTimestampPM}</td>
    //         //         <td>${ city_origin[2] + " - " + city_destination[2]}</td>

    //         //         <td>${amData[index0].logs != null ? '<span class="badge badge-opacity-success me-3">PRESENT</span>' : '<span class="badge badge-opacity-danger me-3">ABSENT</span>' } </td>
    //         //         <td>${amData[index0].transferee == null ? '<span class="badge badge-opacity-success me-3">NO</span>' : amData[index0].transferee == "0" ?  '<span class="badge badge-opacity-success me-3">NO</span>' : '<span class="badge badge-opacity-danger me-3">YES</span>' } </td>
    //         //     </tr>`;

        //             // }



        //         }




        //     } else {
        //         output += `<tr><td colspan="5" class="text-center">NO DATA FOUND</td></tr>`;
        //     }

        //     return output;
        // }

        //SHOW ADD NEW VEHICLE TYPE MODAL
        const showModalAdd = () => {
            $("#add_passenger_forms").validate().resetForm();
            $("#add_passenger_modal").find(".modal-header > h5").text("Add New Passenger").end()
                .modal('show');
        }


        function createNewRow(table) {
            var newRow = document.createElement('tr');
            table.appendChild(newRow);
            return newRow;
        }

        function createQRCodeElement(qrData, size) {
            var qrCodeElement = document.createElement('img');
            qrCodeElement.width = 100; // Set the desired width
            qrCodeElement.height = 100; // Set the desired height
            var qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?data=' + encodeURIComponent(qrData);
            qrCodeUrl += '&size=' + size + 'x' + size; // Add size parameter to the URL
            qrCodeElement.src = qrCodeUrl;
            qrCodeElement.className = 'qrcode';
            return qrCodeElement;
        }

        function addQRCodeToTable(table, qrDataArray, qrCodesPerRow, qrCodeSize) {
            var rowCount = Math.ceil(qrDataArray.length / qrCodesPerRow);

            for (var i = 0; i < rowCount; i++) {
                var row = document.createElement('tr');

                for (var j = i * qrCodesPerRow; j < (i + 1) * qrCodesPerRow && j < qrDataArray.length; j++) {
                    var qrCodeData = qrDataArray[j].passenger_code;
                    var cell = document.createElement('td');
                    cell.style.padding = '10px';
                    var nameElement = document.createElement('p');
                    nameElement.style.fontSize = '10px';
                    nameElement.textContent = qrDataArray[j].firstname + " " + qrDataArray[j].lastname;

                    var qrCodeElement = createQRCodeElement(qrCodeData);
                    cell.appendChild(qrCodeElement);
                    cell.appendChild(nameElement);
                    row.appendChild(cell);
                }

                table.appendChild(row);
            }
        }

        function generateQRCodeArray(qrDataArray) {
            qrDataArray.forEach(function(data, index) {
                var containerId = 'qrcode-' + index;
                generateQRCode(data, containerId);
            });
        }

        const generatePassengerQrCode = () => {
            Swal.fire({
                title: 'Generate passengers qr code?',
                icon: 'warning',
                // text: "The ticket number will save. You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Generate it!'
            }).then((result) => {
                if (result.value) {

                    $.ajax({
                        url: "/get-passenger-by-company/" + $('#generate_company_name').val(),
                        type: "GET",
                        dataType: "JSON",
                        beforeSend: function() {
                            processObject.showProcessLoader();
                        },
                        success: function(data) {

                            var passengersCode = [];

                            for (let index = 0; index < data.passenger.length; index++) {
                                // console.log(response[index].booking_type_name);
                                passengersCode.push(data.passenger[index]);
                                // var passengerName = document.createElement('p');
                                // passengerName.id = data.passenger.id;
                                // document.getElementById('passenger_name').appendChild(
                                //     passengerName);

                            }

                            console.log(passengersCode);
                            var table = document.getElementById('qrcode_passenger_table');

                            addQRCodeToTable(table, passengersCode, 8, 200);
                            // generateQRCodeArray(passengersCode);
                            // const qrContainer = document.getElementById('generate_qrcode');

                            // // Generate the QR code using the QRCode library
                            // new QRCode(qrContainer, {
                            //     text: data.data.booking_code, // The data to encode
                            //     width: 60, // The width of the QR code
                            //     height: 60, // The height of the QR code
                            //     colorDark: '#000000', // The color of the QR code blocks
                            //     colorLight: '#ffffff', // The color of the QR code background
                            //     correctLevel: QRCode.CorrectLevel
                            //         .H // The error correction level
                            // });


                            printJS({
                                printable: 'generate_forms',
                                type: 'html',
                                showModal: true,

                            })
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            swal.fire({
                                title: "Oops! something went wrong.",
                                html: "<b>" + errorThrown +
                                    "! <br>An unexpected error seems to have occured. Why not try refreshing your page? Or you can contact us if the problem persists.</b>",
                                type: "error",
                                footer: '<a href = "mailto: enterprise.cabuyao@gmail.com">Send an email to us!</a>'
                            });
                        },
                        complete: function() {
                            processObject.hideProcessLoader();
                        },

                    });
                }
            })

        }


        const generate = (id) => {
            $('#generate_passenger_table tr').remove();
            $.ajax({
                url: "/get-passenger-by-id/" + id,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                type: "GET",
                beforeSend: function() {
                    processObject.showProcessLoader();
                },
                success: function(data) {
                    console.log(data);
                    if (data.success) {

                        var form = $("#generate_passenger_forms");
                        form.validate().resetForm();
                        form.find(".error").removeClass("error");
                        form.find(".form-control").removeClass(
                            "is-valid");

                        var row = "";
                        var cell = "";
                        var nameElement = "";
                        var qrCodeElement = "";

                        var table_passenger = document.getElementById('generate_passenger_table');
                        var qrCodeData = data.passenger.passenger_code;
                        console.log(qrCodeData);

                        row = document.createElement('tr');
                        cell = document.createElement('td');
                        nameElement = document.createElement('p');
                        qrCodeElement = createQRCodeElement(qrCodeData);


                        cell.style.padding = '10px';
                        nameElement.style.fontSize = '10px';
                        nameElement.textContent = data.passenger.firstname + " " + data.passenger.lastname;

                        cell.appendChild(qrCodeElement);
                        cell.appendChild(nameElement);
                        row.appendChild(cell);

                        table_passenger.appendChild(row);

                        printJS({
                            printable: 'generate_passenger_forms',
                            type: 'html',
                            showModal: true,
                        })

                        // $('#update_sex').val(data.passenger.sex);
                        // $('#update_date_of_birth').val(data.passenger.date_of_birth);
                        // $('#update_description').val(data.data.description);

                    } else {
                        swal.fire({
                            title: "Oops! something went wrong.",
                            icon: "error",
                            html: "<b>" + data
                                .messages +
                                "! <br>An unexpected error seems to have occured. Why not try refreshing your page? Or you can contact us if the problem persists.</b>",
                            type: "error",
                            footer: ''
                        });
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
    </script>
@endsection
