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
                            <button type="button" onclick="showModalAdd()" class="btn btn-success btn-icon-tex">Add New
                                Company</button>
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
                                        Company Code
                                    </th>
                                    <th>
                                        Company Name
                                    </th>
                                    <th>
                                        VAT Number
                                    </th>
                                    <th>
                                        Email
                                    </th>
                                    <th>
                                        Address
                                    </th>
                                    <th>
                                        Contact N0
                                    </th>
                                    <th>
                                        Telephone No
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th @if (Gate::allows('permission', 'updateCompany') || Gate::allows('permission', 'deleteCompany')) style="width: 200px;" @endif>
                                        @if (Gate::allows('permission', 'updateCompany') || Gate::allows('permission', 'deleteCompany'))
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
                                    <label for="region">Company Name <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_company_name"
                                        name="add_company_name" placeholder="Company Name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="region">Acronym<span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="company_name_acronym"
                                        name="company_name_acronym" placeholder="Acronym">
                                </div>
                            </div>
                            <!-- Province -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="province">VAT Number <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_vat_number" name="add_vat_number"
                                        placeholder="VAT Number">
                                </div>
                            </div>

                            <!-- City -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city">Email <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_email" name="add_email"
                                        placeholder="Email">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="province">Contact Number <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_contact_number"
                                        name="add_contact_number" placeholder="Contact Number">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city">Telephone Number <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_tel_number" name="add_tel_number"
                                        placeholder="Telephone Number">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="region">Address <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_address" name="add_address"
                                        placeholder="Address">
                                </div>
                            </div>
                            <!-- Province -->
                           

                            <!-- City -->
                            
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="add_department_multiselect">Departments <small>(Select
                                            multiple department)</small> <span style="color:red"> * </span></label>
                                    <select class="w-100 select2-hidden-accessible" id="add_department_multiselect"
                                        name="add_department_multiselect[]" multiple="" tabindex="-1"
                                        aria-hidden="true">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <h5 class="modal-title" id="add_company_label">Person incharge information</h5><br>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="region">Employee Number <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_emp_num" name="add_emp_num"
                                        placeholder="Employee Number">
                                </div>
                            </div>
                            <!-- Province -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="province">First Name <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_first_name"
                                        name="add_first_name" placeholder="First Name">
                                </div>
                            </div>

                            <!-- City -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="city">Middle Name <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_middle_name"
                                        name="add_middle_name" placeholder="Middle Name">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="city">Last Name <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_last_name" name="add_last_name"
                                        placeholder="Last Name">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="region">Address <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_person_address"
                                        name="add_person_address" placeholder="Address">
                                </div>
                            </div>
                            <!-- Province -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="province">Contact Number <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_person_contact_number"
                                        name="add_person_contact_number" placeholder="Contact Number">
                                </div>
                            </div>

                            <!-- City -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city">Email <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_person_email"
                                        name="add_person_email" placeholder="Email">
                                </div>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
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
                                    <label for="region">Company Name <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_company_name"
                                        name="update_company_name" placeholder="Company Name">
                                </div>
                            </div>
                            <!-- Province -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="province">VAT Number <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_vat_number"
                                        name="update_vat_number" placeholder="VAT Number">
                                </div>
                            </div>

                            <!-- City -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city">Email <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_email" name="update_email"
                                        placeholder="Email">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="region">Address <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_address"
                                        name="update_address" placeholder="updateress">
                                </div>
                            </div>
                            <!-- Province -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="province">Contact Number <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_contact_number"
                                        name="update_contact_number" placeholder="Contact Number">
                                </div>
                            </div>

                            <!-- City -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city">Telephone Number <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_tel_number"
                                        name="update_tel_number" placeholder="Telephone Number">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="update_department_multiselect">Departments <small>(Select
                                            multiple department)</small> <span style="color:red"> * </span></label>
                                    <select class="w-100 select2-hidden-accessible" id="update_department_multiselect"
                                        name="update_department_multiselect[]" multiple="" tabindex="-1"
                                        aria-hidden="true">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <h5 class="modal-title" id="add_company_label">Person incharge information</h5><br>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="region">Employee Number <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_emp_num"
                                        name="update_emp_num" placeholder="Employee Number">
                                </div>
                            </div>
                            <!-- Province -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="province">First Name <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_first_name"
                                        name="update_first_name" placeholder="First Name">
                                </div>
                            </div>

                            <!-- City -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="city">Middle Name <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_middle_name"
                                        name="update_middle_name" placeholder="Middle Name">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="city">Last Name <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_last_name"
                                        name="update_last_name" placeholder="Last Name">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="region">Address <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_person_address"
                                        name="update_person_address" placeholder="Address">
                                </div>
                            </div>
                            <!-- Province -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="province">Contact Number <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_person_contact_number"
                                        name="update_person_contact_number" placeholder="Contact Number">
                                </div>
                            </div>

                            <!-- City -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city">Email <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_person_email"
                                        name="update_person_email" placeholder="Email">
                                </div>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
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
                "sSearch": "Search Company Name:"
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
                    "data": "vat_number"
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
            $("#add_company_modal").find(".modal-header > h5").text("Add New company").end()
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
                    add_company_name: "Please enter company name",
                    company_name_acronym: "Please enter company acronym",
                    add_vat_number: "Please enter vat number",
                    add_email: "Please enter email",
                    add_address: "Please enter address",
                    add_contact_number: "Please enter contact number",
                    add_tel_number: "Please enter tel number",
                    add_emp_num: "Please enter employee number",
                    add_first_name: "Please enter first name",
                    add_middle_name: "Please enter middle name",
                    add_last_name: "Please enter last name",
                    add_person_address: "Please enter home address",
                    add_person_contact_number: "Please enter contact number",
                    add_person_email: "Please enter email",
                    "add_department_multiselect[]": "Please enter department",
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
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Save it!',
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
                                            title: "Saved!",
                                            text: "Successfully!",
                                            icon: 'success',
                                            type: "success",
                                            html: "<b>New company information has been successfully saved.",
                                            // footer: '<a href = "mailto: enterprise.cabuyao@gmail.com">Send an email to us!</a>'
                                        });


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
                                error: function(jqXHR, textStatus,
                                    errorThrown) {
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
                    update_company_name: "Please enter company name",
                    update_vat_number: "Please enter vat number",
                    update_email: "Please enter email",
                    update_address: "Please enter address",
                    update_contact_number: "Please enter contact number",
                    update_tel_number: "Please enter telephone number",
                    update_emp_num: "Please enter employee number",
                    update_first_name: "Please enter first name",
                    update_middle_name: "Please enter middle name",
                    update_last_name: "Please enter last name",
                    update_person_address: "Please enter home address",
                    update_person_contact_number: "Please enter contact number",
                    update_person_email: "Please enter email",
                    "update_department_multiselect[]": "Please enter departments",
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
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Update it!',
                        //footer: '<a href = "mailto: jvn-cgs.com">Send an email to us!</a>'
                    }).then((result) => {
                        if (result.value) {

                            var formData = new FormData($("#update_company_forms").get(0));

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
                                        $('#update_company_modal').modal('hide');
                                        $("#update_company_forms")[0].reset();
                                        var form = $("#update_company_forms");
                                        form.validate().resetForm();
                                        form.find(".error").removeClass("error");
                                        form.find(".form-control").removeClass(
                                            "is-valid");
                                        $('#update_company_modal').modal('hide');
                                        swal.fire({
                                            title: "Updated!",
                                            text: "Successfully Update!",
                                            icon: 'success',
                                            type: "success",
                                            html: "<b>Company details has been successfully updated.",
                                            // footer: '<a href = "mailto: enterprise.cabuyao@gmail.com">Send an email to us!</a>'
                                        });
                                        
                                        table.ajax.reload(null, false);
                                    } else {
                                        Swal.fire({
                                            title: "Oops! something went wrong.",
                                            html: "<b>" + data.messages +
                                                "! <br>An unexpected error seems to have occured. Why not try refreshing your page? Or you can contact us if the problem persists.</b>",
                                            type: "error",
                                            icon: "error",
                                            footer: ''
                                        });
                                        table.ajax.reload(null, false);
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
                            .text("Edit Company Details").end()
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
                            title: "Oops! something went wrong.",
                            html: "<b>" + data.messages +
                                "! <br>An unexpected error seems to have occured. Why not try refreshing your page? Or you can contact us if the problem persists.</b>",
                            type: "error",
                            icon: "error",
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



        //DELETE EVENT
        const removeCompanyRecord = (id) => {
            // const url = '{{ route('get-drivers') }}';
            Swal.fire({
                title: 'Remove Data?',
                icon: 'warning',
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Restore it!'
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
                                    title: "Save!",
                                    text: "Deleted Successfully!",
                                    icon: "success"
                                });
                            } else {
                                Swal.fire({
                                    title: "Oops! something went wrong.",
                                    text: data.messages,
                                    icon: 'success'
                                })
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
            })
        };
    </script>
@endsection
