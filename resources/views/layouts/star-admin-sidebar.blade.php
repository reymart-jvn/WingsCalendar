<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" style="{{ Request::is('dashboard') ? 'color: rgb(84,76,196);' : '' }}" href="dashboard">
                <i class="mdi mdi-grid-large menu-icon"
                    style="{{ Request::is('dashboard') ? 'color: rgb(84,76,196);' : '' }}"></i>
                <span class="menu-title">ダッシュボード</span>
            </a>
        </li>

        @if (Gate::allows('permission', 'viewMainSystemHeader') ||
                Gate::allows('permission', 'createAccount') ||
                Gate::allows('permission', 'viewAccount') ||
                Gate::allows('permission', 'resetAccount') ||
                Gate::allows('permission', 'restoreAccount') ||
                Gate::allows('permission', 'createPermission') ||
                Gate::allows('permission', 'viewPermission'))
            <li class="nav-item nav-category">メインシステム</li>
        @endif
        <li class="nav-item">
            @if (Gate::allows('permission', 'createAccount') ||
                    Gate::allows('permission', 'viewAccount') ||
                    Gate::allows('permission', 'resetAccount') ||
                    Gate::allows('permission', 'restoreAccount'))
                <a class="nav-link" data-bs-toggle="collapse" href="#account-mgnt" aria-expanded='false'
                    aria-controls="account-mgnt">
                    <i class="menu-icon mdi mdi-account-multiple"></i>
                    <span class="menu-title">アカウント管理</span>
                    <i class="menu-arrow"></i>
                </a>
            @endif
            <div class="collapse" id="account-mgnt">
                <ul class="nav flex-column sub-menu" id="myTab">
                    @if (Gate::allows('permission', 'createAccount'))
                        <li class="nav-item"> <a class="nav-link" href="add-new-user"
                                style="{{ Request::is('add-new-user') ? 'color: rgb(84,76,196);' : '' }}">新しいアカウントを作成</a></li>
                    @endif
                    @if (Gate::allows('permission', 'viewAccount'))
                        <li class="nav-item"> <a class="nav-link" href="users-management"
                                style="{{ Request::is('users-management') ? 'color: rgb(84,76,196);' : '' }}">アカウントの管理</a></li>
                    @endif
                    @if (Gate::allows('permission', 'resetAccount'))
                        <li class="nav-item"> <a class="nav-link" href="reset-password-management"
                                style="{{ Request::is('reset-password-management') ? 'color: rgb(84,76,196);' : '' }}">パスワードのリセット</a></li>
                    @endif
                    @if (Gate::allows('permission', 'restoreAccount'))
                        <li class="nav-item"> <a class="nav-link" href="restore-account-management"
                                style="{{ Request::is('restore-account-management') ? 'color: rgb(84,76,196);' : '' }}">アカウントの復元</a></li>
                    @endif
                </ul>
            </div>
        </li>
        <li class="nav-item">
            @if (Gate::allows('permission', 'createPermission') || Gate::allows('permission', 'viewPermission'))
                <a class="nav-link" data-bs-toggle="collapse" href="#permission-mgnt" aria-expanded='false'
                    aria-controls="permission-mgnt">
                    <i class="menu-icon mdi mdi-lock-outline"></i>
                    <span class="menu-title">権限管理</span>
                    <i class="menu-arrow"></i>
                </a>
            @endif
            <div class="collapse" id="permission-mgnt">
                <ul class="nav flex-column sub-menu" id="myTab">
                    @if (Gate::allows('permission', 'createPermission'))
                        <li class="nav-item"> <a class="nav-link" href="create-permission"
                                style="{{ Request::is('create-permission') ? 'color: rgb(84,76,196);' : '' }}">権限の作成</a></li>
                    @endif
                    @if (Gate::allows('permission', 'viewPermission'))
                        <li class="nav-item"> <a class="nav-link" href="permission-management"
                                style="{{ Request::is('permission-management') ? 'color: rgb(84,76,196);' : '' }}">権限管理</a></li>
                    @endif
                </ul>
            </div>
        </li>


        @if (Gate::allows('permission', 'viewCompanyHeader') ||
                Gate::allows('permission', 'viewCompany') ||
                Gate::allows('permission', 'viewDepartment') ||
                Gate::allows('permission', 'viewPosition'))
            <li class="nav-item nav-category">会社管理</li>
        @endif
        <li class="nav-item">
            @if (Gate::allows('permission', 'viewCompany') ||
                    Gate::allows('permission', 'viewDepartment') ||
                    Gate::allows('permission', 'viewPosition'))
                <a class="nav-link" data-bs-toggle="collapse" href="#company-mgnt" aria-expanded='false'
                    aria-controls="company-mgnt">
                    <i class="menu-icon mdi mdi-home-modern"></i>
                    <span class="menu-title">会社管理</span>
                    <i class="menu-arrow"></i>
                </a>
            @endif
            <div class="collapse" id="company-mgnt">
                <ul class="nav flex-column sub-menu" id="myTab">
                    @if (Gate::allows('permission', 'viewCompany'))
                        <li class="nav-item"> <a class="nav-link" href="company-management"
                                style="{{ Request::is('company-management') ? 'color: rgb(84,76,196);' : '' }}">法人管理</a></li>
                    @endif
                    @if (Gate::allows('permission', 'viewDepartment'))
                        <li class="nav-item"> <a class="nav-link" href="department-management"
                                style="{{ Request::is('department-management') ? 'color: rgb(84,76,196);' : '' }}">部署管理</a></li>
                    @endif
                    @if (Gate::allows('permission', 'viewPosition'))
                        <li class="nav-item"> <a class="nav-link" href="position-management"
                                style="{{ Request::is('position-management') ? 'color: rgb(84,76,196);' : '' }}">役職管理
                                </a></li>
                    @endif
                </ul>
            </div>
        </li>

        @if (Gate::allows('permission', 'viewEventHeader') || Gate::allows('permission', 'viewEvent'))
            <li class="nav-item nav-category">イベント管理</li>
        @endif
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#events-mgnt" aria-expanded='false'
                aria-controls="events-mgnt">
                <i class="menu-icon mdi mdi-home-modern"></i>
                <span class="menu-title">イベント管理</span>
                <i class="menu-arrow"></i>
            </a>

            <div class="collapse" id="events-mgnt">
                <ul class="nav flex-column sub-menu" id="myTab">
                    @if (Gate::allows('permission', 'createEvent'))
                    <li class="nav-item"> <a class="nav-link" href="create-event-schedule"
                            style="{{ Request::is('create-event-schedule') ? 'color: rgb(84,76,196);' : '' }}">イベントスケジュール作成</a>
                    </li>
                    @endif
                    @if (Gate::allows('permission', 'viewEvent'))
                    <li class="nav-item"> <a class="nav-link" href="events-management"
                            style="{{ Request::is('events-management') ? 'color: rgb(84,76,196);' : '' }}">イベントリスト</a>
                    </li>
                    @endif

                </ul>
            </div>
        </li>



        @if (Gate::allows('permission', 'viewEventSettingsHeader') || Gate::allows('permission', 'viewEventSettings'))
        <li class="nav-item nav-category">設定</li>
        @endif
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#events-custom-mgnt" aria-expanded='false'
                aria-controls="events-custom-mgnt">
                <i class="menu-icon mdi mdi-home-modern"></i>
                <span class="menu-title">イベント設定</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="events-custom-mgnt">
                <ul class="nav flex-column sub-menu" id="myTab">
                    @if (Gate::allows('permission', 'viewLocation'))
                    <li class="nav-item"> <a class="nav-link" href="location-management"
                            style="{{ Request::is('location-management') ? 'color: rgb(84,76,196);' : '' }}">場所の管理</a>
                    </li>
                    @endif
                    @if (Gate::allows('permission', 'viewActivities'))
                    <li class="nav-item"> <a class="nav-link" href="activity-management"
                            style="{{ Request::is('activity-management') ? 'color: rgb(84,76,196);' : '' }}">活動の管理</a>
                    </li>
                    @endif
                    @if (Gate::allows('permission', 'viewPersonInCharge'))
                    <li class="nav-item"> <a class="nav-link" href="personincharge-management"
                            style="{{ Request::is('personincharge-management') ? 'color: rgb(84,76,196);' : '' }}">担当者の管理</a>
                    </li>
                    @endif

                </ul>
            </div>
        </li>
    </ul>
</nav>
