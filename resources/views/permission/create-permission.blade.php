@extends('layouts.star-admin-app')
@section('css')
    <style>
        .input-group-text {
            line-height: 0.9 !important;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $title }}</h4>
                    <p class="card-description">
                        {{ $label }}
                    </p>
                    <form id="create_form_permission">

                        @csrf
                        @method('POST')


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
                        <input type="text" name="company_acronym" id="company_acronym" hidden>
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
                                                            @if (access_level() == 1)
                                                                <tr>
                                                                    <td>Requirement Management</td>

                                                                    @if (Gate::allows('permission', 'createRequirement'))
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="createRequirement">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    @if (Gate::allows('permission', 'updateRequirement'))
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="updateRequirement">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    @if (Gate::allows('permission', 'viewRequirement'))
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="viewRequirement">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    @if (Gate::allows('permission', 'deleteRequirement'))
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="deleteRequirement">
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
                                                            @endif
                                                            @if (access_level() == 1)
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
                                                            @endif

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
                                                            @if (access_level() == 1)
                                                                <tr>
                                                                    <td>Vehicle Type Management</td>
                                                                    @if (Gate::allows('permission', 'createVehicleType'))
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="createVehicleType">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    @if (Gate::allows('permission', 'updateVehicleType'))
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="updateVehicleType">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    @if (Gate::allows('permission', 'viewVehicleType'))
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="viewVehicleType">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    @if (Gate::allows('permission', 'deleteVehicleType'))
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="deleteVehicleType">
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
                                                            @endif

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
                                                            @if (access_level() == 1)
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
                                                                                name="permission[]"
                                                                                value="restoreCompany">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif
                                                                    <td class="text-center">-
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            @if (access_level() == 1)
                                                                <tr>
                                                                    <td>Department Management</td>
                                                                    @if (Gate::allows('permission', 'createDepartment'))
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="createDepartment">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    @if (Gate::allows('permission', 'updateDepartment'))
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="updateDepartment">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    @if (Gate::allows('permission', 'viewDepartment'))
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="viewDepartment">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    @if (Gate::allows('permission', 'deleteDepartment'))
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="deleteDepartment">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    @if (Gate::allows('permission', 'restoreDepartment'))
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="restoreDepartment">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif
                                                                    <td class="text-center">-
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            @if (access_level() == 1)
                                                                <tr>
                                                                    <td>Position Management</td>
                                                                    @if (Gate::allows('permission', 'createPosition'))
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="createPosition">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    @if (Gate::allows('permission', 'updatePosition'))
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="updatePosition">
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
                                                                                name="permission[]"
                                                                                value="deletePosition">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    @if (Gate::allows('permission', 'restorePosition'))
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="restorePosition">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    <td class="text-center">-
                                                                    </td>
                                                                </tr>
                                                            @endif

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

                                                            @if (access_level() == 1)
                                                                <tr>
                                                                    <td>Booking Type Management</td>
                                                                    @if (Gate::allows('permission', 'createBookingType'))
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="createBookingType">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    @if (Gate::allows('permission', 'updateBookingType'))
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="updateBookingType">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    @if (Gate::allows('permission', 'viewBookingType'))
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="viewBookingType">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    @if (Gate::allows('permission', 'deleteBookingType'))
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="deleteBookingType">
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
                                                            @endif


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

                                                            @if (access_level() == 1)
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
                                                            @endif

                                                            @if (access_level() == 1)
                                                                <tr>
                                                                    <td>Rate Per Trip Management</td>
                                                                    @if (Gate::allows('permission', 'createTripRate'))
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="createTripRate">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    @if (Gate::allows('permission', 'updateTripRate'))
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="updateTripRate">
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
                                                                                name="permission[]"
                                                                                value="deleteTripRate">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    @if (Gate::allows('permission', 'restoreTripRate'))
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="restoreTripRate">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif




                                                                    <td class="text-center">-
                                                                    </td>
                                                                </tr>
                                                            @endif


                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (Gate::allows('permission', 'viewBookingCustomHeader') ||
                                Gate::allows('permission', 'viewBookingCategory') ||
                                access_level() == 1)
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

                        @if (Gate::allows('permission', 'viewReportsHeader') || Gate::allows('permission', 'viewPassengersAttendanceReport'))
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

                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif




                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-fill" id="saveNewRecord">Save
                                Changes</button>
                            {{-- <a href="{{ route('access.index') }}" class="btn btn-warning btn-fill">Back</a> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        let acronym = "";
        let company_acronym = "";
        $.ajax({
            url: '{{ route('get-all-company') }}',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                for (let index = 0; index < response.length; index++) {
                    // console.log(response[index].vehicle_type_name);
                    $('[name="company_name"]').append('<option data-acronym =' + response[index].acronym +
                        ' value=' + response[index].id + '>' + response[
                            index].company_name + '</option>');
                }

            }
        });

        // $('#company_name').on('click', function () {
        //     // Perform your action here
        //     company_acronym = "";
        // });

        $("#company_name").change(function() {
            $("#department").prop('disabled', false);
            $("#department").empty();
            $("#position").prop('disabled', false);
            $("#position").empty();


            var selectedOption = $(this).find(':selected');
            company_acronym = selectedOption.data('acronym');



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
                        acronym = response[index].departments_info.acronym;
                    }

                    $("#department").trigger('change');

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        });

        $("#department").change(function() {
            $("#position").prop('disabled', false);
            $("#position").empty();
            $.ajax({
                url: '{{ route('get-department-has-position') }}',
                type: "GET",
                data: {
                    _token: "{{ csrf_token() }}",
                    'department_id': $("#department").val()
                },
                dataType: "JSON",
                success: function(response) {
                    for (let index = 0; index < response.length; index++) {
                        $('[name="position"]').append('<option value=' + response[index].position.id +
                            '>' +
                            response[index].position.name + '</option>');
                    }

                    $("#department_acronyms").text(response[0].department.acronym);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        });


        $(document).ready(function() {
            $("#create_form_permission").validate({
                rules: {
                    company_name: "required",
                    department: "required",
                    position: "required",
                    level_access: "required"

                },
                messages: {
                    company_name: "Please enter company name",
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
                            // const position = $('#department_acronyms').text() + "" + $('#position').val();
                            //         formData.append('position', position);

                            var formData = new FormData($("#create_form_permission").get(0));
                            const department_acro = company_acronym + "_" + $(
                                '#department_acronyms').text() + "_" + $(
                                '#level_access').val();
                            formData.append('position_level_access', department_acro);

                            $.ajax({
                                url: '/save-new-permission',
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
                                        $("#create_form_permission")[0].reset();
                                        var form = $("#create_form_permission");
                                        form.validate().resetForm();
                                        form.find(".error").removeClass("error");
                                        form.find(".form-control").removeClass(
                                            "is-valid");
                                        Swal.fire({
                                            title: "Saved!",
                                            text: "Successfully!",
                                            icon: 'success',
                                            type: "success",
                                            html: "<b>Your permission has been successfully saved.",
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
    </script>
@endsection
