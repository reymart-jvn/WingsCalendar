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
                        {{-- <button type="button" data-toggle="modal" data-target="#update_modal" class="btn btn-success btn-icon-tex">Add New booking Type</button> --}}

                    </h4>

                    <p class="card-description">
                        {{ $label }}
                    </p>
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="selectpicker form-control" id="grp_company" name="grp_company">
                                            <option value="" disabled selected>Select Company</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-md-3">
                                    <div class="form-group">
                                        <select class="selectpicker form-control" id="grp_driver" name="grp_driver"
                                            >
                                            <option value="" disabled selected>Select Driver</option>
                                            <option value="ALL">ALL</option>
                                        </select>
                                    </div>
                                    <input type="hidden" id="driver_id" name="driver_id">
                                    <input type="hidden" id="driver_full_name" name="driver_full_name">
                                    <input type="hidden" id="van_plate_number" name="van_plate_number">
                                </div> --}}
                                <div class="col-md-4">
                                    <!-- Barangay -->
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"> <span class="mdi mdi-calendar-plus"></span>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="grp_date_from"
                                                name="grp_date_from" placeholder="Date From">
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <!-- Barangay -->
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"> <span class="mdi mdi-calendar-plus"></span>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="grp_date_to" name="grp_date_to"
                                                placeholder="Date To">

                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div>
                                <button onclick="filterFinancialSummary()"
                                    class="btn btn-block btn-sm btn-primary">Filter</button>
                                <button onclick="refreshApproveTable()" class="btn btn-sm btn-warning">Refresh</button>
                                <button onclick="generateBookingTransactions()"
                                    class="btn btn-sm btn-success">Generate</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <br>
                    <div class="row">
                        <div class="col-lg-4 d-flex flex-column">
                            <div class="row flex-grow">
                                <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                                    <div class="card card-gradient">
                                        <div class="card-body">
                                            <div class="circle-shadow-primary">
                                                <i class="mdi mdi-chart-line" style="height:300px;width:300px"></i>
                                            </div>
                                            <h4>Gross Sales</h4>
                                            <h1 class="text-primary" id="gross_sales" name="gross_sales">&#8369; 0</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 d-flex flex-column">
                            <div class="row flex-grow">
                                <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                                    <div class="card card-gradient">
                                        <div class="card-body">
                                            <div class="circle-shadow-success">
                                                <i class="mdi mdi-arrow-down-bold-hexagon-outline"></i>
                                            </div>
                                            <h4>Profit Sales</h4>
                                            <h1 class="text-success" id="profit_sales" name="profit_sales">&#8369; 0</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 d-flex flex-column">
                            <div class="row flex-grow">
                                <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                                    <div class="card card-gradient">
                                        <div class="card-body">
                                            <div class="circle-shadow-info">
                                                <i class="mdi mdi-account-outline"></i>
                                            </div>
                                            <h4>with 12 % VAT</h4>
                                            <h1 class="text-info" id="plus_vat" name="plus_vat">&#8369; 0</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-lg-3 d-flex flex-column">
                            <div class="row flex-grow">
                                <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                                    <div class="card card-gradient">
                                        <div class="card-body">
                                            <div class="circle-shadow-danger">
                                                <i class="mdi mdi-cube-outline"></i>
                                            </div>
                                            <h4>Less Vat</h4>
                                            <h1 class="text-danger">&#8369; 0</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    {{-- <div class="row">

                        <div class="col-lg-12 grid-margin grid-margin-lg-0 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="chartjs-size-monitor">
                                        <div class="chartjs-size-monitor-expand">
                                            <div class=""></div>
                                        </div>
                                        <div class="chartjs-size-monitor-shrink">
                                            <div class=""></div>
                                        </div>
                                    </div>
                                    <div class="chartjs-size-monitor">
                                        <div class="chartjs-size-monitor-expand">
                                            <div class=""></div>
                                        </div>
                                        <div class="chartjs-size-monitor-shrink">
                                            <div class=""></div>
                                        </div>
                                    </div>
                                    <h4 class="card-title">Bar chart</h4>
                                    <canvas id="barChart" width="868" height="243"
                                        style="display: block; width: 868px; height: 243px;"
                                        class="chartjs-render-monitor"></canvas>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="table-responsive pt-3">
                        <table class="table" id="table_id">
                            <thead>
                                <tr>

                              
                                    <th>
                                        <center>FULLNAME
                                    </th>
                                    <th>
                                        <center>PLATE NUMBER
                                    </th>
                                    <th>
                                        <center>TRIPS
                                    </th>
                                    <th>
                                        <center>TOTAL GROSS SALARY
                                    </th>
                                    <th>
                                        <center>OPERATION SALES
                                    </th>
                                    <th>
                                        <center>NET SALARY 
                                    </th>
                                    <th>
                                        <center> ADMIN FEE <br>
                                        (15% of net salary)
                                    </th>
                                    <th>
                                        <center>TOTAL NET SALARY
                                    </th>
                                    <th>
                                        <center>PROFIT SALES <br>
                                        (operation sales + admin fee)
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                             
                                    <th> </th>
                                    <th> </th>
                                    <th id="trips-total"></th>>
                                    <th id="actual-total"></th>
                                    <th id="operation-sales-total"></th>
                                    <th id="less-50-total"></th>
                                    <th id="admin-fee-total"></th>
                                    <th id="less-15-percent-total"></th>
                                    <th></th>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="generate_booking_transactions_modal" tabindex="-1" role="dialog"
        aria-labelledby="generate_booking_transactions_label" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="generate_booking_transactions_label">Add Vehicle Type</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="add_id" name="add_id">
                    <form id="print_driver_forms" method="POST">
                        @csrf
                        @method('POST')
                        <div class="table-responsive w-100">
                            <table style="width:100%">
                                <tbody>
                                    <tr>
                                        <td colspan="8">
                                    <tr>
                                        <td colspan="8" style="font-size:20px;font-weight: bold">
                                            <center>JVN TRANSPORT SERVICES</center>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" style="margin-bottom: 20px;font-size:16px">
                                            <center>Purok 3, San Antonio, Bay 4033,Laguna, Philippines <br>
                                                <hr>
                                        </td>
                                    </tr>

                                    <tr style="font-size:16px">
                                        <td colspan="4" style="margin-bottom: 20px">
                                            DRIVER: <span id="driver_fullname" name="driver_fullname"
                                                style="font-weight:bold"></span><br>
                                            PLATE NUMBER: <span id="van_platenumber" name="van_platenumber"
                                                style="font-weight:bold"></span><br>
                                            ALLOCATION DATE: <span id="allo_from" name="allo_from"
                                                style="font-weight:bold">2023/03/01</span><span> - </span><span
                                                id="allo_to" name="allo_to"
                                                style="font-weight:bold">2023/03/29</span><br>
                                            TOTAL TRIPS: </span><span id="total_trips" style="font-weight:bold">100</span>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table" id="table_driver_trip_transactions">
                                {{-- <thead style="text-align: left;font-size:10px">
                                <tr>
                                    <th style="width:60px;" colspan="6">
                                        Allocation Date:
                                    </th>
                                    
                                    <th>
                                        Company:
                                    </th>
                                </tr>
                            </thead> --}}
                                <thead style="text-align: left;font-size:10px;background-color:black;color:white">
                                    <tr style="padding-left: 10px">
                                        <th style="width:25%">
                                            DATE
                                        </th>
                                        <th style="width:60%">
                                            ROUTE
                                        </th>
                                        <th style="width:15%;">
                                            DIRECTION
                                        </th>
                                        <th style="width:10%">
                                            TOTAL
                                        </th>
                                    </tr>
                                </thead>
                                <tbody style="font-size:13px">

                                </tbody>
                                <tfoot style="font-size:13px">
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th style="text-align: left;font-size:13px">GRAND TOTAL:</th>
                                        <th style="text-align: left;color:red;font-size:13px" id="myGrandTotal"
                                            name="myGrandTotal">40,000
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                        <br>

                </div>
                </form>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="printDriverSlip()">Print</button>
                    <button type="button" class="btn btn-success" onclick="downloadExcel()">Download Excel</button>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/js/ph_address.js') }}"></script>
    <script type="text/JavaScript" src="{{ asset('assets/js/easy.qrcode.min.js') }}"></script>
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
        var financiaSummaryDataDefault = [];
        //DATA TABLE FOR DRIVERS LIST
        let table = new DataTable('#table_id', {
            "processing": true,
            "lengthMenu": [
                [40, 60, 100, -1],
                [40, 60, 100, "All"]
            ],
            "language": {
                "sSearch": "Search Booking Name:"
            },
            "data": financiaSummaryDataDefault,
            "columns": [
             
                {
                    "data": "fullname"
                },
                {
                    "data": "plate_number"
                },
                {
                    "data": "total_trips"
                },
                {
                    "data": "actual"
                },
                {
                    "data": "operation_sales"
                },
                {
                    "data": "less_50"
                },
                {
                    "data": "admin_fee"
                },
                {
                    "data": "less_15_percent"
                },
                {
                    "data": "profit_sales"
                },
            ],
            "columnDefs": [{
                "orderable": false,
                "targets": [1]
            }, ],
            initComplete: function() {
                $('.dataTables_filter input').unbind();
                $('.dataTables_filter input').bind('keyup', function(e) {
                    var code = e.keyCode || e.which;
                    if (code == 13) {
                        table.search(this.value).draw();
                    }
                });
                this.api()
                    .columns()
                    .every(function() {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function(d, j) {
                                select.append('<option value="' + d + '">' + d + '</option>');
                            });
                    });
            },
        });
    </script>
    <script>
        let driver_name;
        let plate_number;
        $(function() {
            $("#grp_date_from").datepicker({
                "dateFormat": "Y-m-d"
            });
            $("#grp_date_to").datepicker({
                "dateFormat": "Y-m-d"
            });
        });

        $.ajax({
            url: '{{ route('get-all-company') }}',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                for (let index = 0; index < response.length; index++) {
                    // console.log(response[index].vehicle_type_name);
                    $('[name="grp_company"]').append('<option value=' + response[index].id + '>' +
                        response[index].company_name + '</option>');

                }

            }
        });


        $.ajax({
            url: '{{ route('get-all-vehicle-with-driver') }}',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log(response);
                for (let index = 0; index < response.length; index++) {
                    // console.log(response[index].booking_type_name);
                    $('[name="grp_driver"]').append('<option value=' + response[index].id +
                        '>' + response[index].vehicle_has_driver.driver.first_name + " " + response[
                            index].vehicle_has_driver.driver.last_name + '</option>');
                }
            }
        });

        $('#grp_driver').change(function() {
            var value = $("#grp_driver").val();
            $.ajax({
                url: '{{ route('get-all-vehicle-with-driver') }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    for (let index = 0; index < response.length; index++) {
                        // console.log(response[index].booking_type_name);
                        if (response[index].id == value) {
                            $("#driver_id").val(response[index].vehicle_has_driver.driver.id);
                            $("#driver_full_name").val(response[index].vehicle_has_driver.driver
                                .first_name + " " + response[index].vehicle_has_driver.driver
                                .last_name);
                            $("#van_plate_number").val(response[index].certificate_of_registration
                                .plate_number);
                        }
                    }
                }
            });
        });

        const financialComputation = () => {
            let grp_date_from = $("#grp_date_from").val();
            let grp_date_to = $("#grp_date_to").val();
            let companyID = $("#grp_company").val();

            // $('#driver_name').val();
            // $('#plate_number').val();
            // $('#total_trips').text();

            grp_date_from = grp_date_from.split('/');
            const year = grp_date_from[2];
            const month = grp_date_from[0].padStart(2, '0');
            const day = grp_date_from[1].padStart(2, '0');
            grp_date_from = `${year}-${month}-${day}`;

            grp_date_to = grp_date_to.split('/');
            const year1 = grp_date_to[2];
            const month1 = grp_date_to[0].padStart(2, '0');
            const day1 = grp_date_to[1].padStart(2, '0');
            grp_date_to = `${year1}-${month1}-${day1}`;

            $.ajax({
                url: "/get-financial-summary/" + companyID + "/" + grp_date_from + "/" + grp_date_to,
                type: 'GET',
                dataType: 'json',
                // beforeSend: function() {
                //     processObject.showProcessLoader();
                // },
                success: function(response) {

                    const gross_sale = response.gross;
                    const plus_vat = response.plus_vat;
                    const profit_sales = response.profit_sales;

                    const formattedGrossSale = gross_sale.toLocaleString();
                    const formattedPlusVat = plus_vat.toLocaleString();
                    const formattedProfitSales = profit_sales.toLocaleString();

                    $("#gross_sales").html("&#x20B1; " + formattedGrossSale);
                    $("#plus_vat").html("&#x20B1; " + formattedPlusVat);
                    $("#profit_sales").html("&#x20B1; " + formattedProfitSales);

                },
                // complete: function() {
                //     processObject.hideProcessLoader();

                // },
            });
        }

        const driverSummary = () => {

            let grp_date_from = $("#grp_date_from").val();
            let grp_date_to = $("#grp_date_to").val();
            let companyID = $("#grp_company").val();

            // $('#driver_name').val();
            // $('#plate_number').val();
            // $('#total_trips').text();

            grp_date_from = grp_date_from.split('/');
            const year = grp_date_from[2];
            const month = grp_date_from[0].padStart(2, '0');
            const day = grp_date_from[1].padStart(2, '0');
            grp_date_from = `${year}-${month}-${day}`;

            grp_date_to = grp_date_to.split('/');
            const year1 = grp_date_to[2];
            const month1 = grp_date_to[0].padStart(2, '0');
            const day1 = grp_date_to[1].padStart(2, '0');
            grp_date_to = `${year1}-${month1}-${day1}`;

            $('#table_id').DataTable().clear().destroy();
            tbl_booking = $('#table_id').DataTable({
                "processing": true,
                "serverSide": true,
                "lengthMenu": [
                    [40, 60, 100, -1],
                    [40, 60, 100, "All"]
                ],
                "language": {
                    "sSearch": "Search Booking Code:"
                },
                "ajax": {
                    "url": '{{ route('get-driver-summary') }}',
                    "dataType": "json",
                    "type": "GET",
                    "data": {
                        _token: "{{ csrf_token() }}",
                        companyID,
                        grp_date_from,
                        grp_date_to
                    }
                },
                "columns": [
                   
                    {
                        "data": "fullname"
                    },
                    {
                        "data": "plate_number"
                    },
                    {
                        "data": "total_trips"
                    },
                    {
                        "data": "actual",
                        "render": function(data, type, row) {
                            // Format the "actual" column with peso sign, comma, and bold style
                            if (type === 'display') {
                                // Format the number with a comma separator and two decimal places
                                var formattedValue = '₱<strong>' + parseFloat(data).toFixed(2).replace(
                                    /\d(?=(\d{3})+\.)/g, '$&,') + '</strong>';
                                return formattedValue;
                            }
                            return data; // Return the original data for sorting and filtering
                        }
                    },
                    {
                        "data": "operation_sales",
                        "render": function(data, type, row) {
                            // Format the "actual" column with peso sign, comma, and bold style
                            if (type === 'display') {
                                // Format the number with a comma separator and two decimal places
                                var formattedValue = '₱<strong>' + parseFloat(data).toFixed(2).replace(
                                    /\d(?=(\d{3})+\.)/g, '$&,') + '</strong>';
                                return formattedValue;
                            }
                            return data; // Return the original data for sorting and filtering
                        }
                    },
                    {
                        "data": "less_50",
                        "render": function(data, type, row) {
                            // Format the "actual" column with peso sign, comma, and bold style
                            if (type === 'display') {
                                // Format the number with a comma separator and two decimal places
                                var formattedValue = '₱<strong>' + parseFloat(data).toFixed(2).replace(
                                    /\d(?=(\d{3})+\.)/g, '$&,') + '</strong>';
                                return formattedValue;
                            }
                            return data; // Return the original data for sorting and filtering
                        }
                    },
                    {
                        "data": "admin_fee",
                        "render": function(data, type, row) {
                            // Format the "actual" column with peso sign, comma, and bold style
                            if (type === 'display') {
                                // Format the number with a comma separator and two decimal places
                                var formattedValue = '₱<strong>' + parseFloat(data).toFixed(2).replace(
                                    /\d(?=(\d{3})+\.)/g, '$&,') + '</strong>';
                                return formattedValue;
                            }
                            return data; // Return the original data for sorting and filtering
                        }
                    },
                    {
                        "data": "less_15_percent",
                        "render": function(data, type, row) {
                            // Format the "actual" column with peso sign, comma, and bold style
                            if (type === 'display') {
                                // Format the number with a comma separator and two decimal places
                                var formattedValue = '₱<strong>' + parseFloat(data).toFixed(2).replace(
                                    /\d(?=(\d{3})+\.)/g, '$&,') + '</strong>';
                                return formattedValue;
                            }
                            return data; // Return the original data for sorting and filtering
                        }
                    },
                    {
                        "data": "profit_sales",
                        "render": function(data, type, row) {
                            // Format the "actual" column with peso sign, comma, and bold style
                            if (type === 'display') {
                                // Format the number with a comma separator and two decimal places
                                var formattedValue = '₱<strong>' + parseFloat(data).toFixed(2).replace(
                                    /\d(?=(\d{3})+\.)/g, '$&,') + '</strong>';
                                return formattedValue;
                            }
                            return data; // Return the original data for sorting and filtering
                        }
                    },
                ],
                // "columnDefs": [{
                //     "orderable": false,
                //     "targets": []
                // }, ],
                initComplete: function() {
                    $('.dataTables_filter input').unbind();
                    $('.dataTables_filter input').bind('keyup', function(e) {
                        var code = e.keyCode || e.which;
                        if (code == 13) {
                            tbl_booking.search(this.value).draw();
                        }
                    });
                },
                "footerCallback": function(row, data, start, end, display) {
                    var api = this.api();
                    // Calculate the actual total
                    var tripsTotal = api.column(2, {
                        page: 'current'
                    }).data().reduce(function(total, value) {
                        return total + parseFloat(value);
                    }, 0);
                    var actualTotal = api.column(3, {
                        page: 'current'
                    }).data().reduce(function(total, value) {
                        return total + parseFloat(value);
                    }, 0);

                    var operationSalesTotal = api.column(4, {
                        page: 'current'
                    }).data().reduce(function(total, value) {
                        return total + parseFloat(value);
                    }, 0);

                    var lessTotal = api.column(5, {
                        page: 'current'
                    }).data().reduce(function(total, value) {
                        return total + parseFloat(value);
                    }, 0);

                    var adminFeeTotal = api.column(6, {
                        page: 'current'
                    }).data().reduce(function(total, value) {
                        return total + parseFloat(value);
                    }, 0);

                    var lessTotal15Percent = api.column(7, {
                        page: 'current'
                    }).data().reduce(function(total, value) {
                        return total + parseFloat(value);
                    }, 0);

                    var profitTotal = api.column(8, {
                        page: 'current'
                    }).data().reduce(function(total, value) {
                        return total + parseFloat(value);
                    }, 0);

                    // Format and style the actual total
                    var formattedTripsTotal = '<strong style="color: black;font-size:18px">' + tripsTotal + '</strong>';
                    var formattedActualTotal = '<strong style="color: red;font-size:18px">₱' + actualTotal
                        .toFixed(2)
                        .replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</strong>';

                    var formattedOperationsTotal = '<strong style="color: black;font-size:18px">₱' +
                        operationSalesTotal
                        .toFixed(2)
                        .replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</strong>';

                    // Format and style the less total
                    var formattedLessTotal = '<strong style="color: red;font-size:18px">₱' + lessTotal
                        .toFixed(2).replace(
                            /\d(?=(\d{3})+\.)/g, '$&,') + '</strong>';

                    var formattedAdminFeeTotal = '<strong style="color: black;font-size:18px">₱' + adminFeeTotal
                        .toFixed(2).replace(
                            /\d(?=(\d{3})+\.)/g, '$&,') + '</strong>';

                    var formattedLess15PercentTotal = '<strong style="color: red;font-size:18px">₱' +
                        lessTotal15Percent
                        .toFixed(2).replace(
                            /\d(?=(\d{3})+\.)/g, '$&,') + '</strong>';
                            var formattedProfitTotal = '<strong style="color: black;font-size:18px">₱' +
                                profitTotal
                        .toFixed(2).replace(
                            /\d(?=(\d{3})+\.)/g, '$&,') + '</strong>';

                    // Update the actual and less totals in the footer row

                    $(api.column(0).footer()).html("");
                    $(api.column(1).footer()).html("");
                    $(api.column(2).footer()).html(formattedTripsTotal);
                    $(api.column(3).footer()).html(formattedActualTotal);
                    $(api.column(4).footer()).html(formattedOperationsTotal);
                    $(api.column(5).footer()).html(formattedLessTotal);
                    $(api.column(6).footer()).html(formattedAdminFeeTotal);
                    $(api.column(7).footer()).html(formattedLess15PercentTotal);
                    $(api.column(8).footer()).html(formattedProfitTotal);
                }
            });

       
        }

        const filterFinancialSummary = () => {
            financialComputation();
            driverSummary();
        }
    </script>
@endsection
