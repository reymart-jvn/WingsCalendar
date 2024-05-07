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

                    <h4 class="card-title">{{ $table_title }}</h4>
                    <p class="card-description">
                        {{ $label }}
                    <div class="table-responsive pt-3">
                        <table class="table table-hover" id="table_id">
                            <thead>
                                <tr>

                                    <th>
                                        Full Name
                                    </th>
                                    {{-- <th>
                                        Date of Birth
                                    </th>
                                    <th>
                                        Address
                                    </th>
                                    <th>
                                        Email
                                    </th> --}}
                                    <th>
                                        Company
                                    </th>
                                    <th>
                                        Department
                                    </th>
                                    <th>
                                        Position
                                    </th>
                                    <th>
                                        Level of Access
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th style="width: 200px;">
                                        Action
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

    <!-- Modal-->
    <div class="modal fade" tabindex="-1" role="dialog" id="view_user_modal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="exampleModalLabel">View Account Details</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="symbol symbol-50 symbol-xl-150">
                                <img style="width: 80%;height:80%" id="show_avatar" />
                                <i class="symbol-badge symbol-badge-bottom bg-success"></i>
                            </div>

                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="">Full Name:</label>
                                <b>
                                    <p style="font-weight:bold; font-size:15" id="show_full_name" name="show_full_name">
                                    </p>
                                </b>
                            </div>
                            <div class="form-group">
                                <label for="">Email Address:</label>
                                <p style="font-weight:bold" id="show_email"></p>
                            </div>
                            <div class="form-group">
                                <label for="">Mobile Number:</label>
                                <p style="font-weight:bold" id="show_contact"></p>
                            </div>
                        </div>
                    </div>
                    <br>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Sex:</label>
                                <p style="font-weight:bold" id="show_sex"></p>
                            </div>
                            <div class="form-group">
                                <label for="">Address:</label>
                                <p style="font-weight:bold" id="show_address"></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Date of Birth:</label>
                                <p style="font-weight:bold" id="show_dob"></p>
                            </div>
                            <div class="form-group">
                                <label for="">Barangay:</label>
                                <p style="font-weight:bold" id="show_barangay"></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Civil Status:</label>
                                <p style="font-weight:bold" id="show_civil_status"></p>
                            </div>
                            <div class="form-group">
                                <label for="">Religion:</label>
                                <p style="font-weight:bold" id="show_religion"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">City:</label>
                                <p style="font-weight:bold" id="show_city"></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Province:</label>
                                <p style="font-weight:bold" id="show_province"></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Region:</label>
                                <p style="font-weight:bold" id="show_region"></p>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            @if (Gate::allows('permission', 'viewAccount') ||
                            Gate::allows('permission', 'viewMainSystemHeader') ||
                            Gate::allows('permission', 'viewPermission'))
                        <div class="accordion accordion-solid-header" id="accordion-4" role="tablist">
                            <div class="card content-wrapper">
                                <div class="card-header" role="tab" id="main-header-label">
                                    <h6 class="mb-0">
                                        <a style="font-size:120%;" data-bs-toggle="collapse" href="#main-header"
                                            aria-controls="main-header" class="">
                                            <i class="mdi mdi-octagon"> </i>&nbsp &nbsp MAIN SYSTEM PERMISSION
                                        </a>
                                    </h6>
                                </div>
                                <div id="main-header" class="collapse" role="tabpanel"
                                    aria-labelledby="main-header-label" data-bs-parent="#accordion-4" style="">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="sorting  text-center" style="width: 200px;">
                                                                Sub-systems </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Create </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Update </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                View </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Delete </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Restore </th>
                                                            <th class="sorting  text-center" style="width: 150px;">
                                                                Reset Password</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
    
                                                        <tr>
                                                            <td>Main System</td>
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                            @if (Gate::allows('permission', 'viewMainSystemHeader'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="viewMainSystemHeader">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                        </tr>
    
                                                        <tr>
                                                            <td>Account Management</td>
                                                            @if (Gate::allows('permission', 'createAccount'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="createAccount">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
                                                            @if (Gate::allows('permission', 'updateAccount'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="updateAccount">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
                                                            @if (Gate::allows('permission', 'viewAccount'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="viewAccount">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
                                                            @if (Gate::allows('permission', 'deleteAccount'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="deleteAccount">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
                                                            @if (Gate::allows('permission', 'restoreAccount'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="restoreAccount">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'resetAccount'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="resetAccount">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <td>Permission Management</td>
                                                            @if (Gate::allows('permission', 'createPermission'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="createPermission">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'updatePermission'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="updatePermission">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'viewPermission'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="viewPermission">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'deletePermission'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="deletePermission">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'restorePermission'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="restorePermission">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'resetPermission'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="resetPermission">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                        </tr>
    
                                                    </tbody>
                                                </table>
                                            </div>
    
                                        </div>
                                    </div>
    
                                </div>
                            </div>
                        </div>
                    @endif
    
                    @if (Gate::allows('permission', 'viewDriver') ||
                            Gate::allows('permission', 'viewRequirement') ||
                            Gate::allows('permission', 'viewComRequirement') ||
                            Gate::allows('permission', 'viewShuttleHeader'))
                        <div class="accordion accordion-solid-header" id="shuttle-card" role="tablist">
                            <div class="card content-wrapper">
                                <div class="card-header" role="tab" id="shuttle-header">
                                    <h6 class="mb-0">
                                        <a style="font-size:120%;" data-bs-toggle="collapse" href="#shuttle-collapse"
                                            aria-controls="shuttle-collapse" class="">
                                            <i class="mdi mdi-octagon"> </i>&nbsp &nbsp SHUTTLE MANAGEMENT
                                        </a>
                                    </h6>
                                </div>
                                <div id="shuttle-collapse" class="collapse" role="tabpanel"
                                    aria-labelledby="shuttle-header" data-bs-parent="#shuttle-card" style="">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="sorting  text-center" style="width: 200px;">
                                                                Sub-systems </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Create </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Update </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                View </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Delete </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Restore </th>
                                                            <th class="sorting  text-center" style="width: 150px;">
                                                                Reset Password</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Shuttle Management Header</td>
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                            @if (Gate::allows('permission', 'viewShuttleHeader'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="viewShuttleHeader">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                        </tr>
    
                                                        <tr>
                                                            <td>Driver's Management</td>
                                                            @if (Gate::allows('permission', 'createDriver'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="createDriver">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'updateDriver'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="updateDriver">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'viewDriver'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="viewDriver">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'deleteDriver'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="deleteDriver">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'restoreDriver'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="restoreDriver">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
                                                            <td class="text-center">-
                                                            </td>
                                                        </tr>
    
                                                        <tr>
                                                            <td>Requirement Management</td>
    
                                                            @if (Gate::allows('permission', 'createRequirement'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="createRequirement">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'updateRequirement'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="updateRequirement">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'viewRequirement'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="viewRequirement">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'deleteRequirement'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="deleteRequirement">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'restoreRequirement'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="restoreRequirement">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
                                                            <td class="text-center">-
                                                            </td>
                                                        </tr>
    
                                                        <tr>
                                                            <td>Compliance Requirement Management</td>
                                                            @if (Gate::allows('permission', 'createComRequirement'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="createComRequirement">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'updateComRequirement'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="updateComRequirement">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'viewComRequirement'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="viewComRequirement">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'deleteComRequirement'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="deleteComRequirement">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'restoreComRequirement'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="restoreComRequirement">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            <td class="text-center">-
                                                            </td>
                                                        </tr>
    
                                                    </tbody>
                                                </table>
                                            </div>
    
                                        </div>
                                    </div>
    
                                </div>
                            </div>
                        </div>
                    @endif
    
                    @if (Gate::allows('permission', 'viewVehicleHeader') ||
                            Gate::allows('permission', 'viewVehicleType') ||
                            Gate::allows('permission', 'viewVehicle'))
                        <div class="accordion accordion-solid-header" id="vehicle-card" role="tablist">
                            <div class="card content-wrapper">
                                <div class="card-header" role="tab" id="vehicle-header">
                                    <h6 class="mb-0">
                                        <a style="font-size:120%;" data-bs-toggle="collapse" href="#vehicle-collapse"
                                            aria-controls="vehicle-collapse" class="">
                                            <i class="mdi mdi-octagon"> </i>&nbsp &nbsp VEHICLE MANAGEMENT
                                        </a>
                                    </h6>
                                </div>
                                <div id="vehicle-collapse" class="collapse" role="tabpanel"
                                    aria-labelledby="vehicle-header" data-bs-parent="#vehicle-card" style="">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="sorting  text-center" style="width: 200px;">
                                                                Sub-systems </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Create </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Update </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                View </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Delete </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Restore </th>
                                                            <th class="sorting  text-center" style="width: 150px;">
                                                                Reset Password</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Vehicle Management Header</td>
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                            @if (Gate::allows('permission', 'viewVehicleHeader'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="viewVehicleHeader">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Vehicle Type Management</td>
                                                            @if (Gate::allows('permission', 'createVehicleType'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="createVehicleType">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'updateVehicleType'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="updateVehicleType">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'viewVehicleType'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="viewVehicleType">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'deleteVehicleType'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="deleteVehicleType">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'restoreVehicleType'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="restoreVehicleType">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            <td class="text-center">-
                                                            </td>
                                                        </tr>
    
                                                        <tr>
                                                            <td>Vehicle Management</td>
                                                            @if (Gate::allows('permission', 'createVehicle'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="createVehicle">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'updateVehicle'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="updateVehicle">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'viewVehicle'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="viewVehicle">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'deleteVehicle'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="deleteVehicle">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'restoreVehicle'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="restoreVehicle">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
                                                            {{-- <td class="text-center"><input type="checkbox"
                                                                    name="permission[]" value="createVehicle">
                                                            </td>
                                                            <td class="text-center"><input type="checkbox"
                                                                    name="permission[]" value="updateVehicle">
                                                            </td>
                                                            <td class="text-center"><input type="checkbox"
                                                                    name="permission[]" value="viewVehicle">
                                                            </td>
                                                            <td class="text-center"><input type="checkbox"
                                                                    name="permission[]" value="deleteVehicle">
                                                            </td>
                                                            <td class="text-center"><input type="checkbox"
                                                                    name="permission[]" value="restoreVehicle">
                                                            </td> --}}
                                                            <td class="text-center">-
                                                            </td>
                                                        </tr>
    
                                                    </tbody>
                                                </table>
                                            </div>
    
                                        </div>
                                    </div>
    
                                </div>
                            </div>
                        </div>
                    @endif
    
    
                    @if (Gate::allows('permission', 'viewShuttleLocationHeader') || Gate::allows('permission', 'viewMap'))
                        <div class="accordion accordion-solid-header" id="shuttle-location-card" role="tablist">
                            <div class="card content-wrapper">
                                <div class="card-header" role="tab" id="shuttle-location-header">
                                    <h6 class="mb-0">
                                        <a style="font-size:120%;" data-bs-toggle="collapse"
                                            href="#shuttle-location-collapse"
                                            aria-controls="shuttle-location-collapse" class="">
                                            <i class="mdi mdi-octagon"> </i>&nbsp &nbsp SHUTTLE LOCATION MANAGEMENT
                                        </a>
                                    </h6>
                                </div>
                                <div id="shuttle-location-collapse" class="collapse" role="tabpanel"
                                    aria-labelledby="shuttle-location-header" data-bs-parent="#shuttle-location-card"
                                    style="">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="sorting  text-center" style="width: 200px;">
                                                                Sub-systems </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Create </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Update </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                View </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Delete </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Restore </th>
                                                            <th class="sorting  text-center" style="width: 150px;">
                                                                Reset Password</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Shuttle Location Management Header</td>
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                            @if (Gate::allows('permission', 'viewShuttleLocationHeader'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="viewShuttleLocationHeader">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Map Management</td>
                                                            @if (Gate::allows('permission', 'createMap'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="createMap">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'updateMap'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="updateMap">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'viewMap'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="viewMap">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'deleteMap'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="deleteMap">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'restoreMap'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="restoreMap">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
                                                            <td class="text-center">-
                                                            </td>
                                                        </tr>
    
                                                    </tbody>
                                                </table>
                                            </div>
    
                                        </div>
                                    </div>
    
                                </div>
                            </div>
                        </div>
                    @endif
    
                    @if (Gate::allows('permission', 'viewCompanyHeader') ||
                            Gate::allows('permission', 'viewCompany') ||
                            Gate::allows('permission', 'viewDepartment') ||
                            Gate::allows('permission', 'viewPosition'))
                        <div class="accordion accordion-solid-header" id="company-card" role="tablist">
                            <div class="card content-wrapper">
                                <div class="card-header" role="tab" id="company-header">
                                    <h6 class="mb-0">
                                        <a style="font-size:120%;" data-bs-toggle="collapse" href="#company-collapse"
                                            aria-controls="company-collapse" class="">
                                            <i class="mdi mdi-octagon"> </i>&nbsp &nbsp COMPANY MANAGEMENT
                                        </a>
                                    </h6>
                                </div>
                                <div id="company-collapse" class="collapse" role="tabpanel"
                                    aria-labelledby="company-header" data-bs-parent="#company-card" style="">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="sorting  text-center" style="width: 200px;">
                                                                Sub-systems </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Create </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Update </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                View </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Delete </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Restore </th>
                                                            <th class="sorting  text-center" style="width: 150px;">
                                                                Reset Password</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Company Management Header</td>
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                            @if (Gate::allows('permission', 'viewCompanyHeader'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="viewCompanyHeader">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Company Management</td>
                                                            @if (Gate::allows('permission', 'createCompany'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="createCompany">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'updateCompany'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="updateCompany">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'viewCompany'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="viewCompany">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'deleteCompany'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="deleteCompany">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'restoreCompany'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="restoreCompany">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
                                                            <td class="text-center">-
                                                            </td>
                                                        </tr>
    
                                                        <tr>
                                                            <td>Department Management</td>
                                                            @if (Gate::allows('permission', 'createDepartment'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="createDepartment">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'updateDepartment'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="updateDepartment">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'viewDepartment'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="viewDepartment">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'deleteDepartment'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="deleteDepartment">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'restoreDepartment'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="restoreDepartment">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
                                                            <td class="text-center">-
                                                            </td>
                                                        </tr>
    
                                                        <tr>
                                                            <td>Position Management</td>
                                                            @if (Gate::allows('permission', 'createPosition'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="createPosition">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'updatePosition'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="updatePosition">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'viewPosition'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="viewPosition">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'deletePosition'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="deletePosition">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'restorePosition'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="restorePosition">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            <td class="text-center">-
                                                            </td>
                                                        </tr>
    
                                                    </tbody>
                                                </table>
                                            </div>
    
                                        </div>
                                    </div>
    
                                </div>
                            </div>
                        </div>
                    @endif
    
                    @if (Gate::allows('permission', 'viewBookingHeader') ||
                            Gate::allows('permission', 'viewBookingType') ||
                            Gate::allows('permission', 'viewBooking') ||
                            Gate::allows('permission', 'viewBookingApproval') ||
                            Gate::allows('permission', 'viewTripRate'))
                        <div class="accordion accordion-solid-header" id="booking-card" role="tablist">
                            <div class="card content-wrapper">
                                <div class="card-header" role="tab" id="booking-header">
                                    <h6 class="mb-0">
                                        <a style="font-size:120%;" data-bs-toggle="collapse" href="#booking-collapse"
                                            aria-controls="booking-collapse" class="">
                                            <i class="mdi mdi-octagon"> </i>&nbsp &nbsp BOOKING MANAGEMENT
                                        </a>
                                    </h6>
                                </div>
                                <div id="booking-collapse" class="collapse" role="tabpanel"
                                    aria-labelledby="booking-header" data-bs-parent="#booking-card" style="">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="sorting  text-center" style="width: 200px;">
                                                                Sub-systems </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Create </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Update </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                View </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Delete </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Restore </th>
                                                            <th class="sorting  text-center" style="width: 150px;">
                                                                Reset Password</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Booking Management Header</td>
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                            @if (Gate::allows('permission', 'viewBookingHeader'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="viewBookingHeader">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                        </tr>
    
                                                        <tr>
                                                            <td>Booking Type Management</td>
                                                            @if (Gate::allows('permission', 'createBookingType'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="createBookingType">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'updateBookingType'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="updateBookingType">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'viewBookingType'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="viewBookingType">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'deleteBookingType'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="deleteBookingType">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'restoreBookingType'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="restoreBookingType">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
    
    
    
                                                            <td class="text-center">-
                                                            </td>
                                                        </tr>
    
    
                                                        <tr>
                                                            <td>Booking Management</td>
                                                            @if (Gate::allows('permission', 'createBooking'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="createBooking">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'updateBooking'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="updateBooking">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'viewBooking'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="viewBooking">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'deleteBooking'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="deleteBooking">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'restoreBooking'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="restoreBooking">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
    
    
    
    
                                                            <td class="text-center">-
                                                            </td>
                                                        </tr>
    
                                                        <tr>
                                                            <td>Booking Approval Management</td>
                                                            @if (Gate::allows('permission', 'createBookingApproval'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="createBookingApproval">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'updateBookingApproval'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="updateBookingApproval">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'viewBookingApproval'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="viewBookingApproval">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'deleteBookingApproval'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="deleteBookingApproval">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'restoreBookingApproval'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="restoreBookingApproval">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
    
    
    
    
                                                            <td class="text-center">-
                                                            </td>
                                                        </tr>
    
    
                                                        <tr>
                                                            <td>Rate Per Trip Management</td>
                                                            @if (Gate::allows('permission', 'createTripRate'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="createTripRate">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'updateTripRate'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="updateTripRate">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'viewTripRate'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="viewTripRate">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'deleteTripRate'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="deleteTripRate">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'restoreTripRate'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="restoreTripRate">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
    
    
    
                                                            <td class="text-center">-
                                                            </td>
                                                        </tr>
    
    
                                                    </tbody>
                                                </table>
                                            </div>
    
                                        </div>
                                    </div>
    
                                </div>
                            </div>
                        </div>
                    @endif
    
                    @if (Gate::allows('permission', 'viewPassengerHeader') ||
                            Gate::allows('permission', 'viewPassenger') ||
                            Gate::allows('permission', 'viewPassengerGroup'))
                        <div class="accordion accordion-solid-header" id="passenger-card" role="tablist">
                            <div class="card content-wrapper">
                                <div class="card-header" role="tab" id="passenger-header">
                                    <h6 class="mb-0">
                                        <a style="font-size:120%;" data-bs-toggle="collapse"
                                            href="#passenger-collapse" aria-controls="passenger-collapse"
                                            class="">
                                            <i class="mdi mdi-octagon"> </i>&nbsp &nbsp PASSENGER MANAGEMENT
                                        </a>
                                    </h6>
                                </div>
                                <div id="passenger-collapse" class="collapse" role="tabpanel"
                                    aria-labelledby="passenger-header" data-bs-parent="#passenger-card"
                                    style="">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="sorting  text-center" style="width: 200px;">
                                                                Sub-systems </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Create </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Update </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                View </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Delete </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Restore </th>
                                                            <th class="sorting  text-center" style="width: 150px;">
                                                                Reset Password</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Passenger Management Header</td>
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                            @if (Gate::allows('permission', 'viewPassengerHeader'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="viewPassengerHeader">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                        </tr>
    
                                                        <tr>
                                                            <td>Passenger Management</td>
                                                            @if (Gate::allows('permission', 'createPassenger'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="createPassenger">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'updatePassenger'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="updatePassenger">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'viewPassenger'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="viewPassenger">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'deletePassenger'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="deletePassenger">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'restorePassenger'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="restorePassenger">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            <td class="text-center">-
                                                            </td>
                                                        </tr>
    
                                                        <tr>
                                                            <td>Passenger Group Management</td>
                                                            @if (Gate::allows('permission', 'createPassengerGroup'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="createPassengerGroup">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'updatePassengerGroup'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="updatePassengerGroup">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'viewPassengerGroup'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="viewPassengerGroup">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'deletePassengerGroup'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="deletePassengerGroup">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'restorePassengerGroup'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="restorePassengerGroup">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            <td class="text-center">-
                                                            </td>
                                                        </tr>
    
                                                    </tbody>
                                                </table>
                                            </div>
    
                                        </div>
                                    </div>
    
                                </div>
                            </div>
                        </div>
                    @endif
    
                    @if (Gate::allows('permission', 'viewBilling') || Gate::allows('permission', 'viewBillingHeader'))
                        <div class="accordion accordion-solid-header" id="billing-card" role="tablist">
                            <div class="card content-wrapper">
                                <div class="card-header" role="tab" id="billing-header">
                                    <h6 class="mb-0">
                                        <a style="font-size:120%;" data-bs-toggle="collapse" href="#billing-collapse"
                                            aria-controls="billing-collapse" class="">
                                            <i class="mdi mdi-octagon"> </i>&nbsp &nbsp BILLING MANAGEMENT
                                        </a>
                                    </h6>
                                </div>
                                <div id="billing-collapse" class="collapse" role="tabpanel"
                                    aria-labelledby="billing-header" data-bs-parent="#billing-card" style="">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="sorting  text-center" style="width: 200px;">
                                                                Sub-systems </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Create </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Update </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                View </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Delete </th>
                                                            <th class="sorting  text-center" style="width: 100px;">
                                                                Restore </th>
                                                            <th class="sorting  text-center" style="width: 150px;">
                                                                Reset Password</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Billing Management Header</td>
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                            @if (Gate::allows('permission', 'viewBillingHeader'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="viewBillingHeader">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                        </tr>
    
                                                        <tr>
                                                            <td>Billing Management</td>
                                                            @if (Gate::allows('permission', 'createBilling'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="createBilling">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'updateBilling'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="updateBilling">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'viewBilling'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="viewBilling">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'deleteBilling'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="deleteBilling">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
                                                            @if (Gate::allows('permission', 'restoreBilling'))
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="restoreBilling">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
    
    
    
    
    
                                                            <td class="text-center">-
                                                            </td>
                                                        </tr>
    
                                                    </tbody>
                                                </table>
                                            </div>
    
                                        </div>
                                    </div>
    
                                </div>
                            </div>
                        </div>
                    @endif
    
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-md-12">
                        </div>
                    </div>



                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>


    <!-- Update Modal -->
    <div class="modal fade" id="update_user_modal" tabindex="-1" role="dialog" aria-labelledby="update_user_label"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="update_user_label">Update Vehicle Type</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="firstname">INSTRUCTION: Please fillout the field with (<span style="color:red"> * </span>).</label><br><br>
                    <form class="forms-sample" id="update_user_forms" method="POST">
                        @csrf
                        @method('POST')
                        <input type="hidden" id="update_id" name="update_id">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="firstname">Fist Name <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="firstname" name="firstname"
                                        placeholder="First Name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="lastname">Last Name <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control" id="lastname" name="lastname"
                                        placeholder="Last Name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="middlename">Middle Name <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control" id="middlename" name="middlename"
                                        placeholder="Middle Name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="suffix">Suffix <span style="color:red"> * </span></label>
                                    <select class="selectpicker form-control" data-live-search="true" name="suffix"
                                        id="suffix">
                                        <option value="" disabled="" selected="">Select...</option>
                                        <option value="II">II</option>
                                        <option value="III">III</option>
                                        <option value="IV">IV</option>
                                        <option value="V">V</option>
                                        <option value="JR">JR</option>
                                        <option value="SR">SR</option>
                                        <option value="NA">NA</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date_of_birth">Date of Birth <span style="color:red"> * </span></label>
                                    {{-- <input type="text" class="form-control" id="date_of_birth"/> --}}

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> <span class="mdi mdi-calendar-plus"></span>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="date_of_birth"
                                            name="date_of_birth" placeholder="Date of Birth">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sex">Sex <span style="color:red"> * </span></label>
                                    <select class="selectpicker form-control" data-live-search="true" name="sex"
                                        id="sex">
                                        <option value="" disabled="" selected="">Select...</option>
                                        <option value="MALE">Male</option>
                                        <option value="FEMALE">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="civil_status">Civil Status <span style="color:red"> * </span></label>
                                    <select class="selectpicker form-control" data-live-search="true" name="civil_status"
                                        id="civil_status">
                                        <option value="" disabled="" selected="">Select...</option>
                                        <option value="SINGLE">Single</option>
                                        <option value="MARRIED">Married</option>
                                        <option value="DIVORCED">Divorced</option>
                                        <option value="SEPARATED">Separated</option>
                                        <option value="WIDOWED">Widowed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="religion">Religion <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control" id="religion" name="religion"
                                        placeholder="Religion">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Region <span style="color:red"> * </span></label>
                                    <select class="form-control" data-live-search="true" id="region" name="region">
                                        <option value="" disabled selected>Select.....</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Province -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Province <span style="color:red"> * </span></label>
                                    <select class="form-control" data-live-search="true" id="province" name="province">
                                        <option value="" disabled selected>Select.....</option>
                                    </select>
                                </div>
                            </div>

                            <!-- City -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>City <span style="color:red"> * </span></label>
                                    <select class="form-control" data-live-search="true" id="city" name="city">
                                        <option value="" disabled selected>Select.....</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- Barangay -->
                                <div class="form-group">
                                    <label>Barangay <span style="color:red"> * </span></label>
                                    <select class="form-control" data-live-search="true" id="barangay" name="barangay">
                                        <option value="" disabled selected>Select.....</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="home_address">Home Adrress <span style="color:red"> * </span></label><small>(e.g. street, block, lot,
                                            unit)</small>
                                        <input type="text" class="form-control" placeholder="Home Address"
                                            name="home_address" id="home_address"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="contact">Contact <span style="color:red"> * </span></label>
                                        <input type="text" class="form-control" id="contact" name="contact"
                                            placeholder="Contact Number">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Email <span style="color:red"> * </span></label>
                                    <input id="email" type="email" name="email" :value="old('email')" required
                                        class="form-control" placeholder="user@gmail.com">
                                </div>
                            </div>
                           
                            <hr>
                            <h5 class="modal-title">User Access</h5>
                            <br>
                            <br>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="region">Employee Number <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control" id="employee_code" name="employee_code"
                                        placeholder="Employee Number">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="region">Company <span style="color:red"> * </span></label>
                                    <select class="selectpicker form-control" id="company_name" name="company_name">
                                        <option value="" disabled selected>Select...</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="region">Department <span style="color:red"> * </span></label>
                                    <select class="selectpicker form-control" id="department" name="department">
                                        <option value="" disabled selected>Select...</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="region">Position <span style="color:red"> * </span></label>
                                    <select class="selectpicker form-control" id="position" name="position">
                                        <option value="" disabled selected>Select...</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="region">Level of Access <span style="color:red"> * </span></label>
                                    <select class="selectpicker form-control" id="access" name="access">
                                        <option value="" disabled selected>Select...</option>
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
        $(function() {
            $('#date_of_birth').datepicker();

        });
    </script>

    <script>
        var departmentID, positionID, permissionAccessID;
        //DATA TABLE FOR DRIVERS LIST
        let table = new DataTable('#table_id', {
            "processing": true,
            "serverSide": true,
            "language": {
                "sSearch": "Search Fullname:"
            },
            "ajax": {
                "url": '{{ route('get-all-users') }}',
                "dataType": "json",
                "type": "GET",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columns": [{
                    "data": "fullname"
                },
                // {
                //     "data": "dob"
                // },
                // {
                //     "data": "address"
                // },
                // {
                //     "data": "email"
                // },
                {
                    "data": "company"
                },
                {
                    "data": "department"
                },
                {
                    "data": "position"
                },
                {
                    "data": "level_access"
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




        //FORM VALIDATION FOR UPDATE
        $(document).ready(function() {
            $("#update_user_forms").validate({
                rules: {
                    firstname: "required",
                    lastname: "required",
                    middlename: "required",
                    suffix: "required",
                    date_of_birth: "required",
                    sex: "required",
                    civil_status: "required",
                    religion: "required",
                    region: "required",
                    province: "required",
                    city: "required",
                    barangay: "required",
                    home_address: "required",
                    contact: "required",
                    company_name: "required",
                    department: "required",
                    position: "required",
                    access: "required",
                    employee_code: "required",

                },
                messages: {
                    firstname: "Please enter your firstname",
                    lastname: "Please enter your lastname",
                    middlename: "Please enter your middlename",
                    suffix: "Please enter your suffix",
                    date_of_birth: "Please enter your date of birth",
                    sex: "Please enter your sex",
                    civil_status: "Please enter your civil status",
                    religion: "Please enter your religion",
                    region: "Please enter your region",
                    province: "Please enter your province",
                    city: "Please enter your city",
                    barangay: "Please enter your barangay",
                    home_address: "Please enter your home address",
                    contact: "Please enter your contact",
                    company_name: "Please enter your company",
                    department: "Please enter your department",
                    position: "Please enter your position",
                    access: "Please enter your level of access",
                    employee_code: "Please enter your employee number",
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

                            var formData = new FormData($("#update_user_forms").get(0));
                            formData.append('txtRegion', $("#region :selected").text());

                            $.ajax({
                                url: '/update-user-info',
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
                                        $('#update_user_modal').modal('hide');
                                        $("#update_user_forms")[0].reset();
                                        var form = $("#update_user_forms");
                                        form.validate().resetForm();
                                        form.find(".error").removeClass("error");
                                        form.find(".form-control").removeClass(
                                            "is-valid");
                                        $('#update_user_modal').modal('hide');
                                        Swal.fire({
                                            title: "Updated!",
                                            text: "Successfully Updated!",
                                            icon: 'success',
                                            type: "success",
                                            html: "<b>User account details has been successfully updated.",
                                            // footer: '<a href = "mailto: enterprise.cabuyao@gmail.com">Send an email to us!</a>'
                                        });
                                        table.ajax.reload(null, false);
                                    } else {
                                        Swal.fire({
                                            title: "Oops! Something went wrong.",
                                            icon: 'error',
                                            html: "<b>" + data
                                                .messages +
                                                "! <br>An unexpected error seems to have occured. Why not try refreshing your page? Or you can contact us if the problem persists.</b>",
                                            type: "error",
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

        $.ajax({
            url: '{{ route('get-all-company') }}',
            type: 'GET',
            dataType: 'json',
            success: function(response) {

                for (let index = 0; index < response.length; index++) {
                    // console.log(response[index].vehicle_type_name);
                    $('[name="company_name"]').append('<option value=' + response[index].id + '>' +
                        response[index].company_name + '</option>');

                    // $('.selectpicker').selectpicker('refresh');
                }



            }
        });

        $("#company_name").change(function() {
            $("#department").prop('disabled', false);
            $("#department").empty();
            $("#position").prop('disabled', false);
            $("#position").empty();
            $("#access").prop('disabled', false);
            $("#access").empty();
            $.ajax({
                url: '{{ route('get-company-has-department') }}',
                type: "GET",
                data: {
                    _token: "{{ csrf_token() }}",
                    'company_id': $("#company_name").val()
                },
                dataType: "JSON",
                success: function(response) {

                    for (let index = 0; index < response.length; index++) {
                        $('[name="department"]').append('<option value=' + response[index]
                            .departments_info.id + '>' +
                            response[index].departments_info.name + '</option>');

                    }

                    $("#department").trigger('change');
                    departmentID != "" ? $("#department").val(departmentID) : "";

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        });

        $("#department").click(function() {
            departmentID = "";
            positionID = "";
            permissionAccessID = "";
        });



        $("#department").change(function() {
            $("#position").prop('disabled', false);
            $("#position").empty();
            $.ajax({
                url: '{{ route('get-department-has-position') }}',
                type: "GET",
                data: {
                    _token: "{{ csrf_token() }}",
                    'department_id': departmentID != "" ? departmentID : $("#department").val()
                },
                dataType: "JSON",
                success: function(response) {
                    // console.log($("#department").val());
                    for (let index = 0; index < response.length; index++) {
                        $('[name="position"]').append('<option value=' + response[index].position.id +
                            '>' +
                            response[index].position.name + '</option>');

                    }

                    $("#position").trigger('change');
                    positionID != "" ? $("#position").val(positionID) : "";




                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        });

        $("#position").click(function() {
            positionID = "";

        });

        $("#position").change(function() {
            $("#access").prop('disabled', false);
            $("#access").empty();
            $.ajax({
                url: '{{ route('get-position-has-access') }}',
                type: "GET",
                data: {
                    _token: "{{ csrf_token() }}",
                    'company_id': $("#company_name").val(),
                    'department_id': departmentID != "" ? departmentID : $("#department").val(),
                    'position_id': positionID != "" ? positionID : $("#position").val(),
                },
                dataType: "JSON",
                success: function(response) {
                    console.log(permissionAccessID);
                    for (let index = 0; index < response.length; index++) {
                        $('[name="access"]').append('<option value=' + response[index].permission.id +
                            '>' +
                            response[index].permission.permission_description + '</option>');
                    }

                    $("#access").val(permissionAccessID);
                    // permissionAccessID != "" ? permissionAccessID : $("#access").val(permissionAccessID);
                    // permissionAccessID != "" ? $("#access").val(permissionAccessID) : "";


                    // $("#department_acronyms").text(response[0].department.acronym);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        });


        //GET VEHICLE TYPE INFO
        const update = (id) => {
            $.ajax({
                url: "/get-users-info-by-id/" + id,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                type: "GET",
                beforeSend: function() {
                    processObject.showProcessLoader();
                },
                success: function(data) {
                    console.log(data);
                    // console.log('manage here');

                    if (data.success) {
                        $('#update_user_modal')
                            .find('.modal-header > h5')
                            .text("Edit User Details").end()
                            .modal('show');
                        $('#update_id').val(data[0].id);
                        $('#firstname').val(data[0].first_name);
                        $('#middlename').val(data[0].middle_name);
                        $('#lastname').val(data[0].last_name);
                        $('#email').val(data[0].user.email);
                        $('#contact').val(data[0].telephone_number);
                        $('#suffix').val(data[0].affiliation);

                        $('#sex').val(data[0].gender);
                        $('#date_of_birth').val(data[0].date_of_birth);
                        $('#civil_status').val(data[0].civil_status);
                        $('#home_address').val(data[0].home_address);
                        $('#religion').val(data[0].religion);
                        $("#province").empty();
                        $("#city").empty();
                        $("#barangay").empty();
                        $("#department").empty();
                        $("#position").empty();
                        $("#company").empty();

                        $('#company_name').val(data[0].person_company_department.company_profile.id)
                            .trigger('change');

                        // $("#department").trigger('change');
                        $('#department').val(data[0].person_company_department.departments_info.id);
                        $('#position').val(data[0].user.employee.employee_has_position.position_id);

                        $('#employee_code').val(data[0].user.employee.employee_code);
                        departmentID = data[0].person_company_department.departments_info.id;

                        positionID = data[0].user.employee.employee_has_position.position_id;

                        permissionAccessID = data[0].user.employee.employee_has_position
                            .employee_position_has_permission_access.permission_has_access.permission.id;
                        // $('select option[value="1"]').attr("selected",true);

                        // $("#department").trigger('change');
                        // $('#department').attr('value',  data[0].person_company_department.departments_info.id);
                        if (data[0].region_id) {
                            $("#region").val(data[0].region_id);

                            //province combo box
                            $.each(myData[$("#region").val()].province_list, function(index, value) {
                                //console.log(index)
                                $("#province").append('<option value="' + index + '">' + index +
                                    '</option>');
                                // console.log(index + " - " + index)
                            });

                            if (data[0].province) {
                                $("#province").val(data[0].province);
                                //city combo box
                                $.each(myData[$("#region").val()].province_list[$("#province").val()]
                                    .municipality_list,
                                    function(index, value) {
                                        $("#city").append('<option value="' + index + '">' + index +
                                            '</option>');
                                    });
                            }

                            if (data[0].city_mun) {
                                $("#city").val(data[0].city_mun);
                                //barangay combo box
                                $.each(myData[$("#region").val()].province_list[$("#province").val()]
                                    .municipality_list[$("#city").val()].barangay_list,
                                    function(index, value) {
                                        $("#barangay").append('<option value="' + value + '">' + value +
                                            '</option>');
                                    });

                            }

                            if (data[0].barangay) {
                                $("#barangay").val(data[0].barangay);
                                //barangay combo box
                                $.each(myData[$("#region").val()].province_list[$("#province").val()]
                                    .municipality_list[$("#city").val()].barangay_list,
                                    function(index, value) {
                                        $("#barangay").append('<option value="' + value + '">' + value +
                                            '</option>');
                                    });

                            }

                        }

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

        //GET VEHICLE TYPE INFO
        const view = (id) => {
            $("input[type=checkbox]").prop('checked', false);
            $.ajax({
                url: "/get-users-info-by-id/" + id,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                type: "GET",
                beforeSend: function() {
                    processObject.showProcessLoader();
                },
                success: function(data) {
                    console.log(data[0].persons_info);
                    if (data.success) {
                        $('#view_user_modal')
                            .find('.modal-header > h5')
                            .text("View Account Details").end()
                            .modal('show');
                        // $('#update_id').val(data.data.id);
                        $('#show_avatar').attr('src', '../assets/images/default-user-image.webp');

                        $('#show_full_name').text(data[0].first_name + " " + data[0]
                            .middle_name + " " + data[0].last_name);
                        $('#show_email').text(data[0].user.email);
                        $('#show_contact').text(data[0].telephone_number);
                        $('#show_sex').text(data[0].gender);
                        $('#show_dob').text(data[0].date_of_birth);
                        $('#show_civil_status').text(data[0].civil_status);
                        $('#show_address').text(data[0].home_address);
                        $('#show_barangay').text(data[0].barangay);
                        $('#show_religion').text(data[0].religion);
                        $('#show_city').text(data[0].city_mun);
                        $('#show_province').text(data[0].province);
                        $('#show_region').text(data[0].region);

                        if (data[1] != null) {
                            for (let index = 0; index < data[1].length; index++) {
                                $("input[value=" + data[1][index] + "]").prop('checked', true);
                            }
                        }
                        // $('#update_description').val(data.data.description);

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
        const removeUserRecord = (id) => {
            // const url = '{{ route('get-drivers') }}';
            Swal.fire({
                title: 'Remove User Data?',
                icon: 'warning',
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete it!'
            }).then((result) => {
                if (result.value) {
                    //process loader true
                    $.ajax({
                        url: "/remove-user-record/" + id,
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
                                    title: "Deactivate User!",
                                    text: "Deleted Successfully!",
                                    icon: "success",
                                    html: "<b>User account has been successfully deactivated.",
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

        const logoutUser = (id) =>
        {
            // Swal.fire({
            //     title: 'Logout this User?',
            //     icon: 'warning',
            //     text: "All devices will be logout",
            //     showCancelButton: true,
            //     confirmButtonColor: '#3085d6',
            //     cancelButtonColor: '#d33',
            //     confirmButtonText: 'Yes, Logout it!'
            // }).then((result) => {
            //     if (result.value) {
            //         //process loader true
            //         $.ajax({
            //             url: "/logout-user/" + id,
            //             data: {
            //                 _token: '{{ csrf_token() }}'
            //             },
            //             type: "GET",
            //             beforeSend: function() {
            //                 processObject.showProcessLoader();
            //             },
            //             success: function(data) {
            //                 // if (data.success) {
            //                 //     table.ajax.reload(null, false);
            //                 //     Swal.fire({
            //                 //         title: "Deactivate User!",
            //                 //         text: "Deleted Successfully!",
            //                 //         icon: "success",
            //                 //         html: "<b>User account has been successfully deactivated.",
            //                 //     });
            //                 // } else {
            //                 //     Swal.fire({
            //                 //         title: "Oops! something went wrong.",
            //                 //         text: data.messages,
            //                 //         icon: 'success'
            //                 //     })
            //                 // }
            //             },
            //             error: function(jqXHR, textStatus, errorThrown) {
            //                 swal.fire({
            //                     title: "Oops! something went wrong.",
            //                     text: errorThrown,
            //                     icon: 'success'
            //                 })
            //             },
            //             complete: function() {
            //                 processObject.hideProcessLoader();
            //             },
            //         });
            //     }
            // })
        }
    </script>

    <script>
        //Start of Function for Address
        let myData = data;
        let region = '';
        let province = '';
        let counter = 1;
        $(document).ready(function() {
            addressAutoFill('#region', '#province', '#city', '#barangay');
            addressAutoFill('#region-2', '#province-2', '#city-2', '#barangay-2');
        });


        function addressAutoFill(selectRegion, selectProvince, selectCity, selectBarangay) {
            var $select = $(selectRegion);
            $.each(myData, function(index, value) {
                $select.append('<option value="' + index + '">' + value.region_name + '</option>');
            });

            $(selectRegion).on('change', function() {
                var selectedRegion = $(this).children("option:selected").val();
                region = selectedRegion;
                var $select = $(selectProvince);
                var $select_city = $(selectCity);
                var $select_brgy = $(selectBarangay);
                $select.empty()
                $select_city.empty()
                $select_brgy.empty()
                $select.append('<option value="" disabled selected>Select.....</option>');
                $select_city.append('<option value="" disabled selected>Select.....</option>');
                $select_brgy.append('<option value="" disabled selected>Select.....</option>');
                $.each(myData[selectedRegion].province_list, function(index, value) {
                    $select.append('<option value="' + index + '">' + index + '</option>');
                });
            });

            $(selectProvince).on('change', function() {
                var selectedProvince = $(this).children("option:selected").val();
                province = selectedProvince;
                var $select = $(selectCity);
                var $select_brgy = $(selectBarangay);
                $select.empty()
                $select_brgy.empty()
                $select.append('<option value="" disabled selected>Select.....</option>');
                $select_brgy.append('<option value="" disabled selected>Select.....</option>');
                $.each(myData[region].province_list[selectedProvince].municipality_list, function(index, value) {
                    $select.append('<option value="' + index + '">' + index + '</option>');
                });
            });

            $(selectCity).on('change', function() {
                var selectedCity = $(this).children("option:selected").val();
                var $select = $(selectBarangay);
                $select.empty()
                $select.append('<option value="" disabled selected>Select.....</option>');
                $.each(myData[region].province_list[province].municipality_list[selectedCity].barangay_list,
                    function(index, value) {
                        $select.append('<option value="' + value + '">' + value + '</option>');
                    });

            });
        }
        //End of Function for Address
    </script>
@endsection
