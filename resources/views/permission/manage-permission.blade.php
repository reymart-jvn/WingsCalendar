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
                                        コード
                                    </th>
                                    <th>
                                        アクセスレベル
                                    </th>
                                    <th>
                                        会社
                                    </th>
                                    <th>
                                        部門
                                    </th>
                                    <th>

                                        位置
                                    </th>
                                    <th>

                                        状態
                                    </th>
                                    <th @if (Gate::allows('permission', 'deletePermission') ||
                                            Gate::allows('permission', 'restorePermission') ||
                                            Gate::allows('permission', 'updatePermission')) style="width: 200px;" @endif style="width: 0px;">
                                        @if (Gate::allows('permission', 'deletePermission') ||
                                                Gate::allows('permission', 'restorePermission') ||
                                                Gate::allows('permission', 'updatePermission'))
                                            アクション
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
                                    <label for="region">会社 *</label>
                                    <select class="selectpicker form-control" id="company_name" name="company_name">
                                        <option value="" disabled selected>選択...</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="region">部門 *</label>
                                    <select class="selectpicker form-control" id="department" name="department">
                                        <option value="" disabled selected>選択...</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="region">位置 *</label>
                                    <select class="selectpicker form-control" id="position" name="position">
                                        <option value="" disabled selected>S選択...</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="width:50%">
                            <label>アクセスのレベル</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text" id="department_acronyms"
                                        name="department_acronyms">DEFAULT</span></div>
                                <input type="text" name="level_access" id="level_access" class="form-control"
                                    placeholder="ACCESS NAME">
                            </div>
                        </div>


                        @if (Gate::allows('permission', 'viewAccount') ||
                                Gate::allows('permission', 'viewMainSystemHeader') ||
                                Gate::allows('permission', 'viewPermission') ||
                                access_level() == 1)
                            <div class="accordion accordion-solid-header" id="accordion-4" role="tablist">
                                <div class="card content-wrapper">
                                    <div class="card-header" role="tab" id="main-header-label">
                                        <h6 class="mb-0">
                                            <a style="font-size:120%;" data-bs-toggle="collapse" href="#main-header"
                                                aria-controls="main-header" class="">
                                                <i class="mdi mdi-octagon"> </i>&nbsp &nbsp メインシステムの権限 (MAIN SYSTEM
                                                PERMISSION)
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

                                                                    サブシステム (Sub-systems) </th>
                                                                <th class="sorting  text-center" style="width: 100px;">
                                                                    作成する (Create) </th>
                                                                <th class="sorting  text-center" style="width: 100px;">
                                                                    アップデート (Update) </th>
                                                                <th class="sorting  text-center" style="width: 100px;">
                                                                    ビュー (View) </th>
                                                                <th class="sorting  text-center" style="width: 100px;">

                                                                    消去 (Delete) </th>
                                                                <th class="sorting  text-center" style="width: 100px;">
                                                                    復元する (Restore) </th>
                                                                <th class="sorting  text-center" style="width: 150px;">

                                                                    パスワードのリセット (Reset Password)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <tr>
                                                                <td>メインシステム (Main System)</td>
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

                                                            {{-- @if (access_level() == 1) --}}
                                                                <tr>
                                                                    <td>ダッシュボード (Dashboard)</td>
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
                                                            {{-- @endif --}}

                                                            <tr>
                                                                <td>Aアカウント管理 (Account Management)</td>
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
                                                                <td>権限管理 (Permission Management)</td>
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
                                Gate::allows('permission', 'viewPosition') ||
                                access_level() == 1)
                            <div class="accordion accordion-solid-header" id="company-card" role="tablist">
                                <div class="card content-wrapper">
                                    <div class="card-header" role="tab" id="company-header">
                                        <h6 class="mb-0">
                                            <a style="font-size:120%;" data-bs-toggle="collapse" href="#company-collapse"
                                                aria-controls="company-collapse" class="">
                                                <i class="mdi mdi-octagon"> </i>&nbsp &nbsp 会社管理 (COMPANY MANAGEMENT)
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

                                                                    サブシステム (Sub-systems) </th>
                                                                <th class="sorting  text-center" style="width: 100px;">
                                                                    作成する (Create) </th>
                                                                <th class="sorting  text-center" style="width: 100px;">
                                                                    アップデート (Update) </th>
                                                                <th class="sorting  text-center" style="width: 100px;">
                                                                    ビュー (View) </th>
                                                                <th class="sorting  text-center" style="width: 100px;">

                                                                    消去 (Delete) </th>
                                                                <th class="sorting  text-center" style="width: 100px;">
                                                                    復元する (Restore) </th>
                                                                <th class="sorting  text-center" style="width: 150px;">

                                                                    パスワードのリセット (Reset Password)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>会社管理ヘッダー (Company Management Header)</td>
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
                                                                    <td>会社経営 (Company Management)</td>
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
                                                                    <td>部門管理 (Department Management)</td>
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
                                                                    <td>ポジション管理t (Position Management)</td>
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
                                                <i class="mdi mdi-octagon"> </i>&nbsp &nbsp イベント管理 (EVENT MANAGEMENT)
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

                                                                    サブシステム (Sub-systems) </th>
                                                                <th class="sorting  text-center" style="width: 100px;">
                                                                    作成する (Create) </th>
                                                                <th class="sorting  text-center" style="width: 100px;">
                                                                    アップデート (Update) </th>
                                                                <th class="sorting  text-center" style="width: 100px;">
                                                                    ビュー (View) </th>
                                                                <th class="sorting  text-center" style="width: 100px;">

                                                                    消去 (Delete) </th>
                                                                <th class="sorting  text-center" style="width: 100px;">
                                                                    復元する (Restore) </th>
                                                                <th class="sorting  text-center" style="width: 150px;">

                                                                    パスワ </th>
                                                            </tr>

                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>イベント管理ヘッダー (Event Management Header)</td>
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

                                                            {{-- @if (access_level() == 1) --}}
                                                                <tr>
                                                                    <td>カレンダー (Calendar)</td>
                                                                    <td class="text-center">-</td>
                                                                    <td class="text-center">-</td>
                                                                    @if (Gate::allows('permission', 'viewGuestCalendar') || access_level() == 1)
                                                                        <td class="text-center"><input type="checkbox"
                                                                                name="permission[]"
                                                                                value="viewGuestCalendar">
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">-</td>
                                                                    @endif

                                                                    <td class="text-center">-</td>
                                                                    <td class="text-center">-</td>
                                                                    <td class="text-center">-</td>
                                                                </tr>
                                                            {{-- @endif --}}

                                                            {{-- @if (access_level() == 1) --}}
                                                                <tr>
                                                                    <td>イベント管理 (Event Management)</td>
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
                                                            {{-- @endif --}}


                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (Gate::allows('permission', 'viewEventSettingsHeader') ||
                                Gate::allows('permission', 'viewEventSettings') ||
                                access_level() == 1)
                            <div class="accordion accordion-solid-header" id="event-settings-card" role="tablist">
                                <div class="card content-wrapper">
                                    <div class="card-header" role="tab" id="event-settings-header">
                                        <h6 class="mb-0">
                                            <a style="font-size:120%;" data-bs-toggle="collapse"
                                                href="#event-settings-collapse" aria-controls="event-settings-collapse"
                                                class="">
                                                <i class="mdi mdi-octagon"> </i>&nbsp &nbsp イベント設定の管理 (EVENT SETTINGS
                                                MANAGEMENT)
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

                                                                    サブシステム (Sub-systems) </th>
                                                                <th class="sorting  text-center" style="width: 100px;">
                                                                    作成する (Create) </th>
                                                                <th class="sorting  text-center" style="width: 100px;">
                                                                    アップデート (Update) </th>
                                                                <th class="sorting  text-center" style="width: 100px;">
                                                                    ビュー (View) </th>
                                                                <th class="sorting  text-center" style="width: 100px;">

                                                                    消去 (Delete) </th>
                                                                <th class="sorting  text-center" style="width: 100px;">
                                                                    復元する (Restore) </th>
                                                                <th class="sorting  text-center" style="width: 150px;">

                                                                    パスワ </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>イベント設定ヘッダー (Event Settings Header)</td>
                                                                <td class="text-center">-</td>
                                                                <td class="text-center">-</td>
                                                                @if (Gate::allows('permission', 'viewEventSettingsHeader') || access_level() == 1)
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

                                                            {{-- @if (access_level() == 1) --}}
                                                                <tr>
                                                                    <td>位置管理 (Location Management)</td>
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
                                                                                name="permission[]" value="viewLocation">
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
                                                            {{-- @endif --}}

                                                            {{-- @if (access_level() == 1) --}}
                                                                <tr>
                                                                    <td>活動管理 (Activities Management)</td>
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
                                                            {{-- @endif --}}


                                                            {{-- @if (access_level() == 1) --}}
                                                                <tr>
                                                                    <td>担当者 管理 (Person in charge management)</td>
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
                                                            {{-- @endif --}}



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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                            <button type="submit" class="btn btn-primary">変更を保存する</button>
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
                "sSearch": "検索権限の説明:"
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
                    company_name: "会社名を入力してください",
                    department: "部門を入力してください",
                    position: "あなたの役職を入力してください",
                    level_access: "アクセスレベルを入力してください"
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
                        title: '実行しますか？',
                        text: "元に戻すことはできません",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: "キャンセル",   
                        confirmButtonText: '更新します。',
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
                                            title: "更新されました！",
                                            text: "正常に更新されました",
                                            icon: 'success',
                                            type: "success",
                                            html: "<b>権限が正常に更新されました。",
                                            // footer: '<a href = "mailto: enterprise.cabuyao@gmail.com">Send an email to us!</a>'
                                        });
                                        table.ajax.reload(null, false);
                                    } else {
                                        Swal.fire({
                                            title: "入力に間違いがあります。",
                                            icon: 'error',
                                            html: "<b>" + data
                                                .messages +
                                                "! <br>予期しないエラーが発生しました。ページの更新をお願い致します。問題が解決しない場合は、管理者までお問い合わせください。</b>",
                                            type: "error",
                                        });
                                        table.ajax.reload(null, false);
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    swal.fire({
                                        title: "入力に間違いがあります。",
                                        html: "<b>" + errorThrown +
                                            "! <br>予期しないエラーが発生しました。ページの更新をお願い致します。問題が解決しない場合は、管理者までお問い合わせください。</b>",
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
                            .text("権限アクセスの編集").end()
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
                            title: "入力に間違いがあります。",
                            icon: 'error',
                            html: "<b>" + data
                                .messages +
                                "! <br>予期しないエラーが発生しました。ページの更新をお願い致します。問題が解決しない場合は、管理者までお問い合わせください。</b>",
                            type: "error",
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    swal.fire({
                        title: "入力に間違いがあります。",
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
                title: '許可を取り消しますか?',
                icon: 'warning',
                text: "元に戻すことはできません",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: "キャンセル",   
                confirmButtonText: 'はい、無効にしてください!'
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
                                    title: "無効化されました！",
                                    text: "正常に非アクティブ化されました!",
                                    icon: "success",
                                    html: "<b>あなたの権限は正常に無効化されました。",
                                });
                            } else {
                                Swal.fire({
                                    title: "入力に間違いがあります。",
                                    icon: 'error',
                                    html: "<b>" + data
                                        .messages +
                                        "! <br>予期しないエラーが発生しました。ページの更新をお願い致します。問題が解決しない場合は、管理者までお問い合わせください。</b>",
                                    type: "error",
                                });
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            swal.fire({
                                title: "入力に間違いがあります。",
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
                title: '権限を有効にしますか?',
                icon: 'warning',
                text: "元に戻すことはできません",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: "キャンセル",   
                confirmButtonText: 'はい、有効化してください!'
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
                                    title: "アクティベートされました！",
                                    text: "正常にアクティベートされました!",
                                    icon: "success",
                                    html: "<b>あなたの権限は正常に有効化されました。",
                                });
                            } else {
                                Swal.fire({
                                    title: "入力に間違いがあります。",
                                    icon: 'error',
                                    html: "<b>" + data
                                        .messages +
                                        "! <br>予期しないエラーが発生しました。ページの更新をお願い致します。問題が解決しない場合は、管理者までお問い合わせください。</b>",
                                    type: "error",
                                });
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            swal.fire({
                                title: "入力に間違いがあります。",
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
