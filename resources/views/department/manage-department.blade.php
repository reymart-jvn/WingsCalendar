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
                        {{-- <button type="button" data-toggle="modal" data-target="#update_modal" class="btn btn-success btn-icon-tex">Add New Vehicle Type</button> --}}
                        @if (Gate::allows('permission', 'createDepartment'))
                            <button type="button" onclick="showModalAdd()" class="btn btn-success btn-icon-tex">Add New
                                Department</button>
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
                                        Department Name
                                    </th>
                                    <th>
                                        Description
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th @if (Gate::allows('permission', 'updateDepartment') || Gate::allows('permission', 'deleteDepartment')) style="width: 200px;" @endif style="width: 0px;">
                                        @if (Gate::allows('permission', 'updateDepartment') || Gate::allows('permission', 'deleteDepartment'))
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
    <div class="modal fade" id="add_department_modal" tabindex="-1" role="dialog" aria-labelledby="add_department_label"
        aria-hidden="true">
        <div class="modal-dialog modal-s" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="add_department_label">Add Department</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" id="add_department_forms" method="POST">
                        @csrf
                        @method('POST')
                        <input type="hidden" id="add_id" name="add_id">
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="add_department_name">Department Name <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_department_name"
                                        name="add_department_name" placeholder="Department Name">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="add_description">Description <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="add_description" name="add_description"
                                        placeholder="Description">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="add_department_multiselect">Positions <small>(Select
                                                multiple position)</small> <span style="color:red"> * </span></label>
                                        <select class="w-100 select2-hidden-accessible" id="add_position_multiselect"
                                            name="add_position_multiselect[]" multiple="" tabindex="-1"
                                            aria-hidden="true">
                                        </select>
                                    </div>
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
    <div class="modal fade" id="update_department_modal" tabindex="-1" role="dialog"
        aria-labelledby="update_department_label" aria-hidden="true">
        <div class="modal-dialog modal-s" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="update_department_label">Update Department Details</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" id="update_department_forms" method="POST">
                        @csrf
                        @method('POST')
                        <input type="hidden" id="update_id" name="update_id">
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="update_department_name">Department Name <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_department_name"
                                        name="update_department_name" placeholder="Department Name">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="update_description">Description <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="update_description"
                                        name="update_description" placeholder="Description">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="update_position_multiselect">Positions <small>(Select
                                            multiple position)</small> <span style="color:red"> * </span></label>
                                    <select class="w-100 select2-hidden-accessible" id="update_position_multiselect"
                                        name="update_position_multiselect[]" multiple="" tabindex="-1"
                                        aria-hidden="true">
                                    </select>
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
        //DATA TABLE FOR DRIVERS LIST
        let table = new DataTable('#table_id', {
            "processing": true,
            "serverSide": true,
            "language": {
                "sSearch": "Search Department Name:"
            },
            "ajax": {
                "url": '{{ route('get-department') }}',
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
                    "data": "name"
                },
                {
                    "data": "description"
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

        function format(d) {
            var data = d.arr.department_has_position;
            console.log(data);
            var output = "";
            output += `<div class="col-md-12">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <th style="width: 50px;" class="text-center">#</th>
                            <th style="width: 70%;">Positions</th>
                            <th>Status</th>
                        </thead>
                        <tbody>`;
            if (data.length > 0) {
                for (let index = 0; index < data.length; index++) {
                    output += `<tr>
                            <td class="text-center">${index + 1}</td>
                            <td>${data[index].position.name}</td>
                            <td><span class="badge badge-success">${data[index].position.status = 1 ? 'active' : 'inactive'}</span></td>
                        </tr>`;
                }
            } else {
                output += `<tr><td colspan="3" class="text-center">No Data Available</td></tr>`;
            }

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


        //SHOW ADD NEW VEHICLE TYPE MODAL
        const showModalAdd = () => {
            $("#add_department_forms").validate().resetForm();
            $("#add_department_modal").find(".modal-header > h5").text("Add New Department").end()
                .modal('show');
        }

        $(function() {
            $('#add_position_multiselect').select2({
                width: '100%',
                dropdownParent: $('#add_department_modal')
            });

            // $('#update_department_multiselect').select2({
            //     width: '100%',
            //     dropdownParent: $('#update_company_modal')
            // });

            addSelectPosition();
        });


        //MULTI SELECT FUNCTION
        $(function() {
            $('#update_position_multiselect').select2({
                width: '100%',
                dropdownParent: $('#update_department_modal')
            });

            updateSelectPosition();
        });


        const addSelectPosition = () => {
            $.ajax({
                url: '{{ route('get-all-position') }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    for (let index = 0; index < response.length; index++) {
                        $('[name="add_position_multiselect[]"]').append('<option value=' +
                            response[index].id + '>' + response[index].name + '</option>');
                    }

                }
            });
        }


        const updateSelectPosition = () => {
            $.ajax({
                url: '{{ route('get-all-position') }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    for (let index = 0; index < response.length; index++) {
                        $('[name="update_position_multiselect[]"]').append('<option value=' +
                            response[index].id + '>' + response[index].name + '</option>');
                    }

                }
            });
        }

        //ADD NEW VEHICLE TYPE
        $(document).ready(function() {
            $("#add_department_forms").validate({
                rules: {
                    add_department_name: "required",
                    add_description: "required",
                    "add_position_multiselect[]": "required",

                },
                messages: {
                    add_department_name: "Please enter department name",
                    add_description: "Please enter description",
                    "add_position_multiselect[]": "Please select positions",
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


                            var formData = new FormData($("#add_department_forms").get(0));

                            $.ajax({
                                url: '/save-new-department',
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
                                        $("#add_department_forms")[0].reset();
                                        var form = $("#add_department_forms");
                                        form.validate().resetForm();
                                        form.find(".error").removeClass("error");
                                        form.find(".form-control").removeClass(
                                            "is-valid");
                                        table.ajax.reload(null, false);
                                        $('#add_department_modal').modal('hide');

                                        swal.fire({
                                            title: "Saved!",
                                            text: "Successfully Saved!",
                                            icon: 'success',
                                            type: "success",
                                            html: "<b>New department data has been successfully saved.",
                                            // footer: '<a href = "mailto: enterprise.cabuyao@gmail.com">Send an email to us!</a>'
                                        });


                                    } else {
                                        swal.fire({
                                            title: "Oops! something went wrong.",
                                            html: "<b>" + data.messages +
                                                "! <br>An unexpected error seems to have occured. Why not try refreshing your page? Or you can contact us if the problem persists.</b>",
                                            type: "error",
                                            footer: ''
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
                    // ---
                }
            });
        });

        //FORM VALIDATION FOR UPDATE
        $(document).ready(function() {
            $("#update_department_forms").validate({
                rules: {
                    update_department_name: "required",
                    update_description: "required",
                    "update_position_multiselect[]": "required",

                },
                messages: {
                    update_department_name: "Please enter department name",
                    update_description: "Please enter description",
                    "update_position_multiselect[]": "Please select positions",
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

                        console.log('working');
                        if (result.value) {

                            var formData = new FormData($("#update_department_forms").get(0));

                            $.ajax({
                                url: '/update-department',
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
                                        $('#update_department_modal').modal('hide');
                                        $("#update_department_forms")[0].reset();
                                        var form = $("#update_department_forms");
                                        form.validate().resetForm();
                                        form.find(".error").removeClass("error");
                                        form.find(".form-control").removeClass(
                                            "is-valid");
                                        $('#update_department_modal').modal('hide');
                                        swal.fire({
                                            title: "Updared!",
                                            text: "Successfully Update!",
                                            icon: 'success',
                                            type: "success",
                                            html: "<b>Department details has been successfully updated.",
                                            // footer: '<a href = "mailto: enterprise.cabuyao@gmail.com">Send an email to us!</a>'
                                        });
                                        table.ajax.reload(null, false);
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
                }
            });
        });


        //GET VEHICLE TYPE INFO
        const update = (id) => {
            $.ajax({
                url: "/get-department-by-id/" + id,
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
                        $('#update_department_modal')
                            .find('.modal-header > h5')
                            .text("Edit Department Details").end()
                            .modal('show');
                        $('#update_id').val(data.data.id);
                        $('#update_department_name').val(data.data.name);
                        $('#update_description').val(data.data.description);


                        var selectedValues = new Array();

                        for (let index = 0; index < data.data.department_has_position.length; index++) {
                            selectedValues[index] = data.data.department_has_position[index].position
                                .id;
                        }
                        $('#update_position_multiselect').val(selectedValues).trigger('change');


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



        //DELETE EVENT
        const removeDepartmentRecord = (id) => {
            // const url = '{{ route('get-drivers') }}';
            Swal.fire({
                title: 'Remove Department Data?',
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
                        url: "/remove-department-record/" + id,
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
                                    title: "Removed!",
                                    text: "Deleted Successfully!",
                                    icon: "success",
                                    html: "<b>Department data has been successfully removed."
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

        const restoreDepartmentRecord = (id) => {
            // const url = '{{ route('get-drivers') }}';
            Swal.fire({
                title: 'Restore this Data?',
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
                        url: "/restore-department-record/" + id,
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
                                    title: "Restored!",
                                    text: "Restored Successfully!",
                                    icon: "success",
                                    html: "<b>Department data has been successfully restored."
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
