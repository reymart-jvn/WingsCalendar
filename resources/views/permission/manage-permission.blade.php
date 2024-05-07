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

        /* .readMoreRemarks .addText {
                                                                                                                                                display: none;
                                                                                                                                            }

                                                                                                                                            .readMoreRemarksReceive .addTextReceive {
                                                                                                                                                display: none;
                                                                                                                                            }

                                                                                                                                            .readMoreRemarksRelease .addTextRelease {
                                                                                                                                                display: none;
                                                                                                                                            }

                                                                                                                                            .readMoreRemarksTerminal .addTextTerminal {
                                                                                                                                                display: none;
                                                                                                                                            } */

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
                    </h4>
                    <p class="card-description">
                        {{ $label }}
                    </p>
                    <div class="table-responsive pt-3">
                        <table class="table table-hover" id="table_id">
                            <thead>
                                <tr>
                                    <th>
                                        Code
                                    </th>
                                    <th>
                                        Access Level
                                    </th>
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
                                        Status
                                    </th>
                                    <th @if (Gate::allows('permission', 'deletePermission') ||
                                            Gate::allows('permission', 'restorePermission') ||
                                            Gate::allows('permission', 'updatePermission')) style="width: 200px;" @endif style="width: 0px;">
                                        @if (Gate::allows('permission', 'deletePermission') ||
                                                Gate::allows('permission', 'restorePermission') ||
                                                Gate::allows('permission', 'updatePermission'))
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


    <!-- Update Modal -->
    <div class="modal fade" id="update_permission_modal" tabindex="-1" role="dialog"
        aria-labelledby="update_permission_label" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="update_permission_label">Update permission Details</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" id="update_permission_forms" method="POST">
                        @csrf
                        @method('POST')
                        <input type="hidden" id="update_id" name="update_id">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="region">Company *</label>
                                    <select class="selectpicker form-control" id="company_name" name="company_name">
                                        <option value="" disabled selected>Select...</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="region">Department *</label>
                                    <select class="selectpicker form-control" id="department" name="department">
                                        <option value="" disabled selected>Select...</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="region">Position *</label>
                                    <select class="selectpicker form-control" id="position" name="position">
                                        <option value="" disabled selected>Select...</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="width:50%">
                            <label>Level of Access</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text" id="department_acronyms"
                                        name="department_acronyms">DEFAULT</span></div>
                                <input type="text" name="level_access" id="level_access" class="form-control"
                                    placeholder="ACCESS NAME">
                            </div>
                        </div>


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
                                                                @if (company() == 1)
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
                                Gate::allows('permission', 'viewShuttleHeader') || access_level() == 1)
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
                                                                @if (Gate::allows('permission', 'createDriver') || company() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="createDriver">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'updateDriver') || company() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="updateDriver">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'viewDriver') || company() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="viewDriver">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'deleteDriver') || company() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="deleteDriver">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'restoreDriver') || company() == 1)
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

                                                                <td>Holiday Management</td>
                                                                @if (Gate::allows('permission', 'createHoliday'))
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="createHoliday">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'updateHoliday'))
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="updateHoliday">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'viewHoliday'))
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="viewHoliday">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'deleteHoliday'))
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="deleteHoliday">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'restoreHoliday'))
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="restoreHoliday">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                <td class="text-center">-
                                                                </td>
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





                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (access_level() == 1)
                            <div class="accordion accordion-solid-header" id="booking-custom-card" role="tablist">
                                <div class="card content-wrapper">
                                    <div class="card-header" role="tab" id="booking-custom-header">
                                        <h6 class="mb-0">
                                            <a style="font-size:120%;" data-bs-toggle="collapse"
                                                href="#booking-custom-collapse" aria-controls="booking-custom-collapse"
                                                class="">
                                                <i class="mdi mdi-octagon"> </i>&nbsp &nbsp BOOKING CUSTOMIZATION
                                            </a>
                                        </h6>
                                    </div>
                                    <div id="booking-custom-collapse" class="collapse" role="tabpanel"
                                        aria-labelledby="booking-custom-header" data-bs-parent="#booking-custom-card"
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
                                                                <td>Booking Customization Header</td>
                                                                <td class="text-center">-</td>
                                                                <td class="text-center">-</td>
                                                                @if (Gate::allows('permission', 'viewBookingCustomHeader') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="viewBookingCustomHeader">
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
                                                                @if (Gate::allows('permission', 'createBookingType') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="createBookingType">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'updateBookingType') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="updateBookingType">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'viewBookingType') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="viewBookingType">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'deleteBookingType') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="deleteBookingType">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'restoreBookingType') || access_level() == 1)
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
                                                                <td>Booking Category Management</td>
                                                                @if (Gate::allows('permission', 'createBookingCategory') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="createBookingCategory">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'updateBookingCategory') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="updateBookingCategory">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'viewBookingCategory') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="viewBookingCategory">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'deleteBookingCategory') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="deleteBookingCategory">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'restoreBookingCategory') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="restoreBookingCategory">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif




                                                                <td class="text-center">-
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Rate Per Trip Management</td>
                                                                @if (Gate::allows('permission', 'createTripRate') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="createTripRate">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'updateTripRate') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="updateTripRate">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'viewTripRate') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="viewTripRate">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'deleteTripRate') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="deleteTripRate">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'restoreTripRate') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="restoreTripRate">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif
                                                                <td class="text-center">-
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Shifting Management</td>
                                                                @if (Gate::allows('permission', 'createShifting') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="createShifting">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'updateShifting') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="updateShifting">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'viewShifting') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="viewShifting">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'deleteShifting') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="deleteShifting">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'restoreShifting') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="restoreShifting">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif
                                                                <td class="text-center">-
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>Change Service Unit Management</td>
                                                                @if (Gate::allows('permission', 'createChangeUnit') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="createChangeUnit">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'updateChangeUnit') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="updateChangeUnit">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'viewChangeUnit') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="viewChangeUnit">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'deleteChangeUnit') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="deleteChangeUnit">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'restoreChangeUnit') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="restoreChangeUnit">
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
                                Gate::allows('permission', 'viewPassengerGroup') || access_level() == 1)
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
                                                                @if (Gate::allows('permission', 'viewPassengerHeader') || access_level() == 1)
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
                                                                @if (Gate::allows('permission', 'createPassenger') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="createPassenger">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'updatePassenger') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="updatePassenger">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'viewPassenger') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="viewPassenger">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'deletePassenger') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="deletePassenger">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'restorePassenger') || access_level() == 1)
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
                                                                @if (Gate::allows('permission', 'createPassengerGroup') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="createPassengerGroup">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'updatePassengerGroup') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="updatePassengerGroup">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'viewPassengerGroup') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="viewPassengerGroup">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'deletePassengerGroup') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="deletePassengerGroup">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'restorePassengerGroup') || access_level() == 1)
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

                        @if (Gate::allows('permission', 'viewBilling') || Gate::allows('permission', 'viewBillingHeader') || access_level() == 1)
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
                                                                            name="permission[]"
                                                                            value="viewBillingHeader">
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

                                                            <tr>
                                                                <td>Billing Summary Dashboard</td>
                                                                @if (Gate::allows('permission', 'createBilling'))
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="createBillingDashboard">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'updateBilling'))
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="updateBillingDashboard">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'viewBilling'))
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="viewBillingDashboard">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'deleteBilling'))
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="deleteBillingDashboard">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'restoreBilling'))
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="restoreBillingDashboard">
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

                        @if (Gate::allows('permission', 'viewPurchasing') || Gate::allows('permission', 'viewPurchasingHeader') || access_level() == 1)
                        <div class="accordion accordion-solid-header" id="purchasing-card" role="tablist">
                            <div class="card content-wrapper">
                                <div class="card-header" role="tab" id="purchasing-header">
                                    <h6 class="mb-0">
                                        <a style="font-size:120%;" data-bs-toggle="collapse" href="#purchasing-collapse"
                                            aria-controls="purchasing-collapse" class="">
                                            <i class="mdi mdi-octagon"> </i>&nbsp &nbsp PURCHASING MANAGEMENT
                                        </a>
                                    </h6>
                                </div>
                                <div id="purchasing-collapse" class="collapse" role="tabpanel"
                                    aria-labelledby="purchasing-header" data-bs-parent="#purchasing-card" style="">
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
                                                            <td>Purchasing Management Header</td>
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                            @if (Gate::allows('permission', 'viewPurchasingHeader') || access_level() == 1)
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="viewPurchasingHeader">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif

                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                        </tr>

                                                        <tr>
                                                            <td>Purchase Request Management</td>
                                                            @if (Gate::allows('permission', 'createPurchaseRequest') || access_level() == 1)
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="createPurchaseRequest">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif

                                                            @if (Gate::allows('permission', 'updatePurchaseRequest') || access_level() == 1)
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="updatePurchaseRequest">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif

                                                            @if (Gate::allows('permission', 'viewPurchaseRequest') || access_level() == 1)
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="viewPurchaseRequest">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif

                                                            @if (Gate::allows('permission', 'deletePurchaseRequest') || access_level() == 1)
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="deletePurchaseRequest">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif

                                                            @if (Gate::allows('permission', 'restorePurchaseRequest') || access_level() == 1)
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="restorePurchaseRequest">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
                                                            <td class="text-center">-
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>Consolidate Purchase Request</td>
                                                            @if (Gate::allows('permission', 'createConsolidateRequest') || access_level() == 1)
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="createConsolidateRequest">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif

                                                            @if (Gate::allows('permission', 'updateConsolidateRequest') || access_level() == 1)
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="updateConsolidateRequest">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif

                                                            @if (Gate::allows('permission', 'viewConsolidateRequest') || access_level() == 1)
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="viewConsolidateRequest">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif

                                                            @if (Gate::allows('permission', 'deleteConsolidateRequest') || access_level() == 1)
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="deleteConsolidateRequest">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif

                                                            @if (Gate::allows('permission', 'restoreConsolidateRequest') || access_level() == 1)
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="restoreConsolidateRequest">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
                                                            <td class="text-center">-
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>Approve Consolidate Purchase Request</td>
                                                            @if (Gate::allows('permission', 'createApproveConsolidateRequest') || access_level() == 1)
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="createApproveConsolidateRequest">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif

                                                            @if (Gate::allows('permission', 'updateApproveConsolidateRequest') || access_level() == 1)
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="updateApproveConsolidateRequest">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif

                                                            @if (Gate::allows('permission', 'viewApproveConsolidateRequest') || access_level() == 1)
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="viewApproveConsolidateRequest">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif

                                                            @if (Gate::allows('permission', 'deleteApproveConsolidateRequest') || access_level() == 1)
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="deleteApproveConsolidateRequest">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif

                                                            @if (Gate::allows('permission', 'restoreApproveConsolidateRequest') || access_level() == 1)
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]" value="restoreApproveConsolidateRequest">
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

                        @if (Gate::allows('permission', 'viewReportsHeader') || Gate::allows('permission', 'viewPassengersAttendanceReport') || access_level() == 1)
                            <div class="accordion accordion-solid-header" id="Reports-card" role="tablist">
                                <div class="card content-wrapper">
                                    <div class="card-header" role="tab" id="Reports-header">
                                        <h6 class="mb-0">
                                            <a style="font-size:120%;" data-bs-toggle="collapse"
                                                href="#Reports-collapse" aria-controls="Reports-collapse"
                                                class="">
                                                <i class="mdi mdi-octagon"> </i>&nbsp &nbsp REPORTS MANAGEMENT
                                            </a>
                                        </h6>
                                    </div>
                                    <div id="Reports-collapse" class="collapse" role="tabpanel"
                                        aria-labelledby="Reports-header" data-bs-parent="#Reports-card"
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
                                                                <td>Reports Management Header</td>
                                                                <td class="text-center">-</td>
                                                                <td class="text-center">-</td>
                                                                @if (Gate::allows('permission', 'viewReportsHeader'))
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="viewReportsHeader">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                <td class="text-center">-</td>
                                                                <td class="text-center">-</td>
                                                                <td class="text-center">-</td>
                                                            </tr>

                                                            <tr>
                                                                <td>Passenger Attendance Report</td>
                                                                @if (Gate::allows('permission', 'createPassengersAttendanceReport'))
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="createPassengersAttendanceReport">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'updatePassengersAttendanceReport'))
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="updatePassengersAttendanceReport">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'viewPassengersAttendanceReport'))
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="viewPassengersAttendanceReport">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'deletePassengersAttendanceReport'))
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="deletePassengersAttendanceReport">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'restorePassengersAttendanceReport'))
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="restorePassengersAttendanceReport">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif





                                                                <td class="text-center">-
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>Financial Summary</td>

                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="createFinancialSummaryReport">
                                                                </td>

                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="updateFinancialSummaryReport">
                                                                </td>

                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="viewFinancialSummaryReport">
                                                                </td>

                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="deleteFinancialSummaryReport">
                                                                </td>

                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="restoreFinancialSummaryReport">
                                                                </td>
                                                                <td class="text-center">-</td>
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



                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/js/ph_address.js') }}"></script>
    <script>
        var departmentID, positionID;
        //DATA TABLE FOR DRIVERS LIST
        let table = new DataTable('#table_id', {
            "processing": true,
            "serverSide": true,
            "language": {
                "sSearch": "Search Department Name:"
            },
            "ajax": {
                "url": '{{ route('get-permissions') }}',
                "dataType": "json",
                "type": "GET",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columns": [{
                    "data": "code"
                }, {
                    "data": "access_level"
                },
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
            $("#update_permission_forms").validate({
                rules: {
                    company_name: "required",
                    department: "required",
                    position: "required",
                    level_access: "required"

                },
                messages: {
                    ucompany_name: "Please enter company name",
                    department: "Please enter department",
                    position: "Please enter position",
                    level_access: "Please enter level of access"
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

                            var formData = new FormData($("#update_permission_forms").get(0));
                            const department_acro = $('#level_access').val();
                            formData.append('position_level_access', department_acro);

                            $.ajax({
                                url: '/update-permission',
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
                                        $('#update_permission_modal').modal('hide');
                                        $("#update_permission_forms")[0].reset();
                                        var form = $("#update_permission_forms");
                                        form.validate().resetForm();
                                        form.find(".error").removeClass("error");
                                        form.find(".form-control").removeClass(
                                            "is-valid");
                                        $('#update_permission_modal').modal('hide');
                                        swal.fire({
                                            title: "Updated!",
                                            text: "Successfully!",
                                            icon: 'success',
                                            type: "success",
                                            html: "<b>Your permission has been successfully updated.",
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
                    for (let index = 0; index < response.length; index++) {
                        $('[name="position"]').append('<option value=' + response[index].position.id +
                            '>' +
                            response[index].position.name + '</option>');

                    }

                    $("#position").val(positionID);
                    $("#department_acronyms").text(response[0].department.acronym);


                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        });

        //GET VEHICLE TYPE INFO
        const update = (id) => {
            $("input[type=checkbox]").prop('checked', false);
            $.ajax({
                url: "/get-permission-by-id/" + id,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                type: "GET",
                beforeSend: function() {
                    processObject.showProcessLoader();
                },
                success: function(data) {
                    console.log(data);
                    // $("#permission").removeAttr('checked');
                    // $("#company_name").empty();
                    //         $("#department").empty();
                    //         $("#position").empty();
                    if (data.success) {
                        $('#update_permission_modal')
                            .find('.modal-header > h5')
                            .text("Edit Permission Access").end()
                            .modal('show');


                        $('#update_id').val(data.permission.id);
                        let access = data.permission.permission_description;
                        console.log(access);
                        const myArray = access.split("_");

                        $('#company_name').val(data.company_profile.id).trigger("change");
                        // $('#position').val(data.position.id);
                        departmentID = data.department.id;
                        positionID = data.position.id;
                        console.log(positionID);

                        $('#department_acronyms').text(data.department.acronym + '_');
                        $('#level_access').val(access);

                        if (data.access != null) {
                            for (let index = 0; index < data.access.length; index++) {
                                $("input[value=" + data.access[index] + "]").prop('checked', true);
                            }
                        }

                    } else {
                        Swal.fire({
                            title: "Oops! Something went wrong.",
                            icon: 'error',
                            html: "<b>" + data
                                .messages +
                                "! <br>An unexpected error seems to have occured. Why not try refreshing your page? Or you can contact us if the problem persists.</b>",
                            type: "error",
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
        const removePermissionRecord = (id) => {
            // const url = '{{ route('get-drivers') }}';
            Swal.fire({
                title: 'Deactivate Permission?',
                icon: 'warning',
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Deactivate it!'
            }).then((result) => {
                if (result.value) {
                    //process loader true
                    $.ajax({
                        url: "/remove-permission-record/" + id,
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
                                    text: "Deactivated!",
                                    icon: "success",
                                    html: "<b>Your permission has been successfully deactivated.",
                                });
                            } else {
                                Swal.fire({
                                    title: "Oops! Something went wrong.",
                                    icon: 'error',
                                    html: "<b>" + data
                                        .messages +
                                        "! <br>An unexpected error seems to have occured. Why not try refreshing your page? Or you can contact us if the problem persists.</b>",
                                    type: "error",
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


        const restorePermissionRecord = (id) => {
            // const url = '{{ route('get-drivers') }}';
            Swal.fire({
                title: 'Activate Permission?',
                icon: 'warning',
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Activate it!'
            }).then((result) => {
                if (result.value) {
                    //process loader true
                    $.ajax({
                        url: "/restore-permission-record/" + id,
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
                                    title: "Activated!",
                                    text: "Successfully Activated!",
                                    icon: "success",
                                    html: "<b>Your permission has been successfully activated.",
                                });
                            } else {
                                Swal.fire({
                                    title: "Oops! Something went wrong.",
                                    icon: 'error',
                                    html: "<b>" + data
                                        .messages +
                                        "! <br>An unexpected error seems to have occured. Why not try refreshing your page? Or you can contact us if the problem persists.</b>",
                                    type: "error",
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
