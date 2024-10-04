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
                        <table class="table table-hover" id="table_id" width="100%">
                            <thead>
                                <tr>

                                    <th>
                                        氏名
                                    </th>
                                    {{-- <th>
                                        Date of Birth
                                    </th>
                                    <th>
                                        Address
                                    </th> --}}
                                    <th>
                                        メールアドレス
                                    </th> 
                                    <th>
                                        アクセスレベル
                                    </th>
                                  
                                    <th>
                                        ステータス
                                    </th>
                                    <th style="width: 200px;">
                                        アクション
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
        <div class="modal-dialog modal-xl"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">アカウント詳細の表示</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="symbol symbol-50 symbol-xl-150">
                                <img style="width: 70%;height:70%" id="show_avatar" />
                                <i class="symbol-badge symbol-badge-bottom bg-success"></i>
                            </div>

                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">氏名:</label>
                                <b>
                                    <p style="font-weight:bold; font-size:15" id="show_full_name" name="show_full_name">
                                    </p>
                                </b>
                            </div>
                            <div class="form-group">
                                <label for="">メールアドレス:</label>
                                <p style="font-weight:bold" id="show_email"></p>
                            </div>
                            <div class="form-group">
                                <label for="">性別:</label>
                                <p style="font-weight:bold" id="show_sex"></p>
                            </div>
                           
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">生年月日:</label>
                                <p style="font-weight:bold" id="show_dob"></p>
                            </div>
                            <div class="form-group">
                                <label for="">住所:</label>
                                <p style="font-weight:bold" id="show_address"></p>
                            </div>
                        </div>
                    </div>
                 

                    <hr>
                    
                        <h5 class="modal-title" id="exampleModalLabel">User Permissions</h5>
                        <hr>
                   
                   
                        @if (Gate::allows('permission', 'viewAccount') ||
                                Gate::allows('permission', 'viewMainSystemHeader') ||
                                Gate::allows('permission', 'viewPermission') || access_level() == 1)
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

                                                            @if (access_level() == 1)
                                                            <tr>
                                                                <td>Dashboard</td>
                                                                <td class="text-center">-</td>
                                                                <td class="text-center">-</td>
                                                                @if (Gate::allows('permission', 'viewDashboard') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="viewDashboard">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                <td class="text-center">-</td>
                                                                <td class="text-center">-</td>
                                                                <td class="text-center">-</td>
                                                            </tr>
                                                             @endif

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

                             @if (Gate::allows('permission', 'viewCompanyHeader') ||
                                Gate::allows('permission', 'viewCompany') ||
                                Gate::allows('permission', 'viewDepartment') ||
                                Gate::allows('permission', 'viewPosition') || access_level() == 1 )
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


                        @if (Gate::allows('permission', 'viewEventHeader') || Gate::allows('permission', 'viewEvent') || access_level() == 1)
                            <div class="accordion accordion-solid-header" id="event-card" role="tablist">
                                <div class="card content-wrapper">
                                    <div class="card-header" role="tab" id="event-header">
                                        <h6 class="mb-0">
                                            <a style="font-size:120%;" data-bs-toggle="collapse" href="#event-collapse"
                                                aria-controls="event-collapse" class="">
                                                <i class="mdi mdi-octagon"> </i>&nbsp &nbsp EVENT MANAGEMENT
                                            </a>
                                        </h6>
                                    </div>
                                    <div id="event-collapse" class="collapse" role="tabpanel"
                                        aria-labelledby="event-header" data-bs-parent="#event-card" style="">
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
                                                                    -</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Event Management Header</td>
                                                                <td class="text-center">-</td>
                                                                <td class="text-center">-</td>
                                                                @if (Gate::allows('permission', 'viewEventHeader') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="viewEventHeader">
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
                                                                <td>Calendar</td>
                                                                <td class="text-center">-</td>
                                                                <td class="text-center">-</td>
                                                                @if (Gate::allows('permission', 'viewGuestCalendar') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]" value="viewGuestCalendar">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                <td class="text-center">-</td>
                                                                <td class="text-center">-</td>
                                                                <td class="text-center">-</td>
                                                            </tr>
                                                        @endif

                                                            @if (access_level() == 1)
                                                                <tr>
                                                                    <td>Event Management</td>
                                                                    @if (Gate::allows('permission', 'createEvent') || access_level() == 1)
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]" value="createEvent">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    @if (Gate::allows('permission', 'updateEvent') || access_level() == 1)
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]" value="updateEvent">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    @if (Gate::allows('permission', 'viewEvent') || access_level() == 1)
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]" value="viewEvent">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    @if (Gate::allows('permission', 'deleteEvent') || access_level() == 1)
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]" value="deleteEvent">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    @if (Gate::allows('permission', 'restoreEvent') || access_level() == 1)
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]" value="restoreEvent">
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

                        @if (Gate::allows('permission', 'viewEventSettingsHeader') || Gate::allows('permission', 'viewEventSettings')|| access_level() == 1)
                            <div class="accordion accordion-solid-header" id="event-settings-card" role="tablist">
                                <div class="card content-wrapper">
                                    <div class="card-header" role="tab" id="event-settings-header">
                                        <h6 class="mb-0">
                                            <a style="font-size:120%;" data-bs-toggle="collapse"
                                                href="#event-settings-collapse" aria-controls="event-settings-collapse"
                                                class="">
                                                <i class="mdi mdi-octagon"> </i>&nbsp &nbsp EVENT SETTINGS MANAGEMENT
                                            </a>
                                        </h6>
                                    </div>
                                    <div id="event-settings-collapse" class="collapse" role="tabpanel"
                                        aria-labelledby="event-settings-header" data-bs-parent="#event-settings-card"
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
                                                                    -</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Event Settings Header</td>
                                                                <td class="text-center">-</td>
                                                                <td class="text-center">-</td>
                                                                @if (Gate::allows('permission', 'viewEventSettingsHeader') || access_level() == 1 )
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="viewEventSettingsHeader">
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
                                                                    <td>Location Management</td>
                                                                    @if (Gate::allows('permission', 'createLocation') || access_level() == 1)
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="createLocation">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    @if (Gate::allows('permission', 'updateLocation') || access_level() == 1)
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="updateLocation">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    @if (Gate::allows('permission', 'viewLocation') || access_level() == 1)
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="viewLocation">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    @if (Gate::allows('permission', 'deleteLocation') || access_level() == 1)
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="deleteLocation">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    @if (Gate::allows('permission', 'restoreLocation') || access_level() == 1)
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="restoreLocation">
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
                                                                <td>Activities Management</td>
                                                                @if (Gate::allows('permission', 'createActivities') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="createActivities">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'updateActivities') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="updateActivities">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'viewActivities') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="viewActivities">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'deleteActivities') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="deleteActivities">
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">-</td>
                                                                @endif

                                                                @if (Gate::allows('permission', 'restoreActivities') || access_level() == 1)
                                                                    <td class="text-center"><input type="checkbox"
                                                                            name="permission[]"
                                                                            value="restoreActivities">
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
                                                            <td>Person In Charge Management</td>
                                                            @if (Gate::allows('permission', 'createPersonInCharge') || access_level() == 1)
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="createPersonInCharge">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif

                                                            @if (Gate::allows('permission', 'updatePersonInCharge') || access_level() == 1)
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="updatePersonInCharge">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif

                                                            @if (Gate::allows('permission', 'viewPersonInCharge') || access_level() == 1)
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="viewPersonInCharge">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif

                                                            @if (Gate::allows('permission', 'deletePersonInCharge') || access_level() == 1)
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="deletePersonInCharge">
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif

                                                            @if (Gate::allows('permission', 'restorePersonInCharge') || access_level() == 1)
                                                                <td class="text-center"><input type="checkbox"
                                                                        name="permission[]"
                                                                        value="restorePersonInCharge">
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
                <div class="modal-header">
                    <h5 class="modal-title" id="update_user_label">Update Vehicle Type</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <label for="firstname">(<span style="color:red"> * </span>)の箇所を記入してください .</label>
                    <form class="forms-sample" id="update_user_forms" method="POST">
                        @csrf
                        @method('POST')
                        <input type="hidden" id="update_id" name="update_id">
                        
                        <br>
                        <br>
                    <h5 class="modal-title" id="exampleModalLabel">個人インフォメーション</h5>
                    <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firstname">氏名 <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control " id="fullname" name="fullname"
                                        placeholder="氏名">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date_of_birth">生年月日 <span style="color:red"> * </span></label>
                                    {{-- <input type="text" class="form-control" id="date_of_birth"/> --}}

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> <span class="mdi mdi-calendar-plus"></span>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="date_of_birth"
                                            name="date_of_birth" placeholder="生年月日">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sex">性別 <span style="color:red"> * </span></label>
                                    <select class="selectpicker form-control" data-live-search="true" name="sex"
                                        id="sex">
                                        <option value="" disabled="" selected="">選択...</option>
                                        <option value="MALE">男性</option>
                                        <option value="FEMALE">女性</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="home_address">自宅住所 <span style="color:red"> * </span></label><small>(e.g. street, block, lot,
                                            unit)</small>
                                        <input type="text" class="form-control" placeholder="自宅住所"
                                            name="home_address" id="home_address"></textarea>
                                    </div>
                                </div>
                            </div>
                          

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">電子メール <span style="color:red"> * </span></label>
                                    <input id="email" type="email" name="email" :value="old('email')" required
                                        class="form-control" placeholder="user@gmail.com">
                                </div>
                            </div>

                        </div>
                        
                        <br>
                        <h5 class="modal-title" id="exampleModalLabel">ユーザーアクセス</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="region">会社名 <span style="color:red"> * </span></label>
                                    <select class="selectpicker form-control" id="company_name" name="company_name">
                                        <option value="" disabled selected>選択...</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="region">部署 <span style="color:red"> * </span></label>
                                    <select class="selectpicker form-control" id="department" name="department">
                                        <option value="" disabled selected>選択...</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="region">役職 <span style="color:red"> * </span></label>
                                    <select class="selectpicker form-control" id="position" name="position">
                                        <option value="" disabled selected>選択...</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="region">アクセスレベル <span style="color:red"> * </span></label>
                                    <select class="selectpicker form-control" id="access" name="access">
                                        <option value="" disabled selected>選択...</option>
                                    </select>
                                </div>
                            </div>





                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                    <button type="submit" class="btn btn-primary">保存</button>
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
                "sSearch": "氏名検索:"
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
                {
                    "data": "email"
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
                "targets": [3, 4]
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
                    fullname: "required",
                    date_of_birth: "required",
                    sex: "required",
                    home_address: "required",
                    company_name: "required",
                    department: "required",
                    position: "required",
                    access: "required",
                    email: "required"

                },
                messages: {

                    fullname: "氏名の入力をお願いします",
                    date_of_birth: "生年月日の入力をお願いします",
                    sex: "性別の入力をお願いします",
                    home_address: "住所の入力をお願いします",
                    email: "メールアドレスの入力をお願いします",
                    company_name: "会社名の入力をお願いします",
                    department: "部署の入力をお願いします",
                    position: "役職の入力をお願いします",
                    access: "アクセスレベルの入力をお願いします",
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
                        title: '更新してもよろしいですか？',
                        text: "元に戻すことはできません",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: "キャンセル",   
                        confirmButtonText: 'はい。更新いたします。',
                        //footer: '<a href = "mailto: jvn-cgs.com">Send an email to us!</a>'
                    }).then((result) => {

                        if (result.value) {
                            var formData = new FormData($("#update_user_forms").get(0));
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
                                            text: "正しく更新されました。",
                                            icon: 'success',
                                            type: "success",
                                            html: "<b>User account details has been successfully updated.",
                                            // footer: '<a href = "mailto: enterprise.cabuyao@gmail.com">Send an email to us!</a>'
                                        });
                                        table.ajax.reload(null, false);
                                    } else {
                                        Swal.fire({
                                            title: "予期しないエラーが発生いたしました。",
                                            icon: 'error',
                                            html: "<b>" + data
                                                .messages +
                                                "! <br>もしくは管理業者までお問い合わせお願い致します。</b>",
                                            type: "error",
                                        });
                                        table.ajax.reload(null, false);
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    swal.fire({
                                        title: "予期しないエラーが発生いたしました。",
                                        html: "<b>" + errorThrown +
                                            "! <br>もしくは管理業者までお問い合わせお願い致します。</b>",
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
                            .text("ユーザー詳細の編集").end()
                            .modal('show');
                        $('#update_id').val(data[0].id);
                        $('#fullname').val(data[0].fullname);
                        $('#email').val(data[0].user.email);

                        $('#sex').val(data[0].gender);
                        $('#date_of_birth').val(data[0].date_of_birth);
                        $('#home_address').val(data[0].home_address);
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


                    } else {
                        Swal.fire({
                            title: "予期しないエラーが発生いたしました。",
                            text: data.messages,
                            icon: 'success'
                        })
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    swal.fire({
                        title: "予期しないエラーが発生いたしました。",
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

                        $('#show_full_name').text(data[0].fullname);
                        $('#show_email').text(data[0].user.email);
                        $('#show_sex').text(data[0].gender);
                        $('#show_dob').text(data[0].date_of_birth);
                        $('#show_address').text(data[0].home_address);

                        if (data[1] != null) {
                            for (let index = 0; index < data[1].length; index++) {
                                $("input[value=" + data[1][index] + "]").prop('checked', true);
                            }
                        }
                        // $('#update_description').val(data.data.description);

                    } else {
                        Swal.fire({
                            title: "予期しないエラーが発生いたしました。",
                            text: data.messages,
                            icon: 'success'
                        })
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    swal.fire({
                        title: "予期しないエラーが発生いたしました。",
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
            Swal.fire({
                title: 'Remove User Data?',
                icon: 'warning',
                text: "元に戻すことはできません",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: "キャンセル",   
                confirmButtonText: 'はい。削除いたします。'
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
                                    text: "正しく削除されました。",
                                    icon: "success",
                                    // html: "<b>User account has been successfully deactivated.",
                                });
                            } else {
                                Swal.fire({
                                    title: "予期しないエラーが発生いたしました。",
                                    text: data.messages,
                                    icon: 'success'
                                })
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            swal.fire({
                                title: "予期しないエラーが発生いたしました。",
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
