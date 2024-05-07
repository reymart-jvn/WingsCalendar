
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" style="{{ Request::is('dashboard') ? 'color: rgb(45, 185, 120);' : '' }}" href="dashboard">
                <i class="mdi mdi-grid-large menu-icon"
                    style="{{ Request::is('dashboard') ? 'color: rgb(45, 185, 120);' : '' }}"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        {{-- Main System Sidebar --}}
        @if (Gate::allows('permission', 'viewMainSystemHeader') ||
                Gate::allows('permission', 'createAccount') ||
                Gate::allows('permission', 'viewAccount') ||
                Gate::allows('permission', 'resetAccount') ||
                Gate::allows('permission', 'restoreAccount') ||
                Gate::allows('permission', 'createPermission') ||
                Gate::allows('permission', 'viewPermission'))
            <li class="nav-item nav-category">Main System</li>
        @endif
        <li class="nav-item">
            @if (Gate::allows('permission', 'createAccount') ||
                    Gate::allows('permission', 'viewAccount') ||
                    Gate::allows('permission', 'resetAccount') ||
                    Gate::allows('permission', 'restoreAccount'))
                <a class="nav-link" data-bs-toggle="collapse" href="#account-mgnt" aria-expanded='false'
                    aria-controls="account-mgnt">
                    <i class="menu-icon mdi mdi-account-multiple"></i>
                    <span class="menu-title">Account Mgmt</span>
                    <i class="menu-arrow"></i>
                </a>
            @endif
            <div class="collapse" id="account-mgnt">
                <ul class="nav flex-column sub-menu" id="myTab">
                    @if (Gate::allows('permission', 'createAccount'))
                        <li class="nav-item"> <a class="nav-link" href="add-new-user"
                                style="{{ Request::is('add-new-user') ? 'color: rgb(45, 185, 120);' : '' }}">Create New
                                Account</a></li>
                    @endif
                    @if (Gate::allows('permission', 'viewAccount'))
                        <li class="nav-item"> <a class="nav-link" href="users-management"
                                style="{{ Request::is('users-management') ? 'color: rgb(45, 185, 120);' : '' }}">Manage
                                Account</a></li>
                    @endif
                    @if (Gate::allows('permission', 'resetAccount'))
                        <li class="nav-item"> <a class="nav-link" href="reset-password-management"
                                style="{{ Request::is('reset-password-management') ? 'color: rgb(45, 185, 120);' : '' }}">Reset
                                Password</a></li>
                    @endif
                    @if (Gate::allows('permission', 'restoreAccount'))
                        <li class="nav-item"> <a class="nav-link" href="restore-account-management"
                                style="{{ Request::is('restore-account-management') ? 'color: rgb(45, 185, 120);' : '' }}">Restore
                                Account</a></li>
                    @endif
                </ul>
            </div>
        </li>
        <li class="nav-item">
            @if (Gate::allows('permission', 'createPermission') || Gate::allows('permission', 'viewPermission'))
                <a class="nav-link" data-bs-toggle="collapse" href="#permission-mgnt" aria-expanded='false'
                    aria-controls="permission-mgnt">
                    <i class="menu-icon mdi mdi-lock-outline"></i>
                    <span class="menu-title">Permission Mgmt</span>
                    <i class="menu-arrow"></i>
                </a>
            @endif
            <div class="collapse" id="permission-mgnt">
                <ul class="nav flex-column sub-menu" id="myTab">
                    @if (Gate::allows('permission', 'createPermission'))
                        <li class="nav-item"> <a class="nav-link" href="create-permission"
                                style="{{ Request::is('create-permission') ? 'color: rgb(45, 185, 120);' : '' }}">Create
                                Permission</a></li>
                    @endif
                    @if (Gate::allows('permission', 'viewPermission'))
                        <li class="nav-item"> <a class="nav-link" href="permission-management"
                                style="{{ Request::is('permission-management') ? 'color: rgb(45, 185, 120);' : '' }}">Manage
                                Permission</a></li>
                    @endif
                </ul>
            </div>
        </li>

        @if (Gate::allows('permission', 'viewPassengerHeader') || Gate::allows('permission', 'viewPassenger'))
            <li class="nav-item nav-category">Passenger Management</li>
        @endif
        <li class="nav-item">
            @if (Gate::allows('permission', 'viewPassenger'))
                <a class="nav-link" data-bs-toggle="collapse" href="#passenger-mgnt" aria-expanded='false'
                    aria-controls="passenger-mgnt">
                    <i class="menu-icon mdi mdi-account-multiple"></i>
                    <span class="menu-title">Passenger Mgmt</span>
                    <i class="menu-arrow"></i>
                </a>
            @endif
            <div class="collapse" id="passenger-mgnt">
                <ul class="nav flex-column sub-menu" id="myTab">
                    @if (Gate::allows('permission', 'viewPassenger'))
                        <li class="nav-item"> <a class="nav-link" href="passenger-management"
                                style="{{ Request::is('passenger-management') ? 'color: rgb(45, 185, 120);' : '' }}">Manage
                                Passenger</a></li>
                    @endif
                    @if (Gate::allows('permission', 'viewPassengerGroup'))
                        <li class="nav-item"> <a class="nav-link" href="passenger-group-management"
                                style="{{ Request::is('passenger-group-management') ? 'color: rgb(45, 185, 120);' : '' }}">Manage
                                Passenger Group</a></li>
                    @endif
                </ul>
            </div>
        </li>
        @if (Gate::allows('permission', 'viewBookingHeader'))
            <li class="nav-item nav-category">Booking Management</li>
        @endif
        <li class="nav-item">
            @if (Gate::allows('permission', 'viewBookingType') || Gate::allows('permission', 'viewBooking'))
                <a class="nav-link" data-bs-toggle="collapse" href="#booking-mgnt" aria-expanded='false'
                    aria-controls="booking-mgnt">
                    <i class="menu-icon mdi mdi-book"></i>
                    <span class="menu-title">Booking Mgmt</span>
                    <i class="menu-arrow"></i>
                </a>
            @endif
            <div class="collapse" id="booking-mgnt">
                <ul class="nav flex-column sub-menu" id="myTab">
                    {{-- @if (Gate::allows('permission', 'viewBooking'))
                        <li class="nav-item"> <a class="nav-link" href="add-new-booking"
                                style="{{ Request::is('add-new-booking') ? 'color: rgb(45, 185, 120);' : '' }}">Create
                                New
                                Booking</a></li>
                    @endif --}}
                    @if (Gate::allows('permission', 'createBooking'))
                        <li class="nav-item"> <a class="nav-link" href="import-booking"
                                style="{{ Request::is('import-booking') ? 'color: rgb(45, 185, 120);' : '' }}">Import
                                Booking</a></li>
                    @endif
                    @if (Gate::allows('permission', 'viewBooking'))
                        <li class="nav-item"> <a class="nav-link" href="booking-management"
                                style="{{ Request::is('booking-management') ? 'color: rgb(45, 185, 120);' : '' }}">Manage
                                Booking</a></li>
                    @endif
                       

                    @if (Gate::allows('permission', 'viewBookingApproval'))
                        <li class="nav-item"> <a class="nav-link" href="booking-group-approval-management"
                                style="{{ Request::is('booking-group-approval-management') ? 'color: rgb(45, 185, 120);' : '' }}">
                                Booking Group Approval</a></li>
                    @endif
                    @if (Gate::allows('permission', 'deleteBooking'))
                    <li class="nav-item"> <a class="nav-link" href="booking-approve-cancellation"
                            style="{{ Request::is('booking-approve-cancellation') ? 'color: rgb(45, 185, 120);' : '' }}">Approve/Cancel
                            Booking</a></li>
                    @endif

                </ul>
            </div>
        </li>

        @if (Gate::allows('permission', 'viewBookingCustomHeader'))
            <li class="nav-item nav-category">Booking Customization</li>
        @endif
        <li class="nav-item">
            @if (Gate::allows('permission', 'viewBookingCustomHeader'))
                <a class="nav-link" data-bs-toggle="collapse" href="#booking-options" aria-expanded='false'
                    aria-controls="booking-options">
                    <i class="menu-icon mdi mdi-settings"></i>
                    <span class="menu-title">Booking Cm</span>
                    <i class="menu-arrow"></i>
                </a>
            @endif
            <div class="collapse" id="booking-options">
                <ul class="nav flex-column sub-menu" id="myTab">
                   
                    @if (Gate::allows('permission', 'viewBookingType'))
                        <li class="nav-item"> <a class="nav-link" href="booking-type-management"
                                style="{{ Request::is('booking-type-management') ? 'color: rgb(45, 185, 120);' : '' }}">Manage
                                Booking Type</a></li>
                    @endif
                    @if (Gate::allows('permission', 'viewBookingCategory'))
                        <li class="nav-item"> <a class="nav-link" href="booking-category-management"
                                style="{{ Request::is('booking-category-management') ? 'color: rgb(45, 185, 120);' : '' }}">Manage
                                Booking Category</a></li>
                    @endif
                    @if (Gate::allows('permission', 'viewTripRate'))
                        <li class="nav-item"> <a class="nav-link" href="rate-per-trip-management"
                                style="{{ Request::is('rate-per-trip-management') ? 'color: rgb(45, 185, 120);' : '' }}">Manage
                                Rate Per Trip</a></li>
                    @endif
                    @if (Gate::allows('permission', 'viewShifting'))
                        <li class="nav-item"> <a class="nav-link" href="shifting-management"
                                style="{{ Request::is('shifting-management') ? 'color: rgb(45, 185, 120);' : '' }}">Manage
                                Shifting</a></li>
                    @endif
                    @if (Gate::allows('permission', 'viewChangeUnit'))
                        <li class="nav-item"> <a class="nav-link" href="change-service-unit-management"
                                style="{{ Request::is('change-service-unit-management') ? 'color: rgb(45, 185, 120);' : '' }}">Manage
                                Change Unit</a></li>
                    @endif
                    @if (Gate::allows('permission', 'viewPosition'))
                        <li class="nav-item"> <a class="nav-link" href="holiday-management"
                                style="{{ Request::is('holiday-management') ? 'color: rgb(45, 185, 120);' : '' }}">Manage
                                Holidays</a></li>
                    @endif
                    

                </ul>
            </div>
        </li>


        {{-- Drivers Management Sidebar --}}

        @if (Gate::allows('permission', 'viewShuttleHeader') ||
                Gate::allows('permission', 'createDriver') ||
                Gate::allows('permission', 'viewDriver'))
            <li class="nav-item nav-category">Shuttle Management</li>
        @endif
        <li class="nav-item">
            @if (Gate::allows('permission', 'createDriver') || Gate::allows('permission', 'viewDriver'))
                <a class="nav-link" data-bs-toggle="collapse" href="#drivers-mgnt" aria-expanded='false'
                    aria-controls="drivers-mgnt">
                    <i class="menu-icon mdi mdi-account"></i>
                    <span class="menu-title">Drivers Mgmt</span>
                    <i class="menu-arrow"></i>
                </a>
            @endif
            <div class="collapse" id="drivers-mgnt">
                <ul class="nav flex-column sub-menu" id="myTab">
                    @if (Gate::allows('permission', 'createDriver'))
                        <li class="nav-item"> <a class="nav-link" href="add-new-driver"
                                style="{{ Request::is('add-new-driver') ? 'color: rgb(45, 185, 120);' : '' }}">Add New
                                Driver</a></li>
                    @endif
                    @if (Gate::allows('permission', 'viewDriver'))
                        <li class="nav-item"> <a class="nav-link" href="driver-management"
                                style="{{ Request::is('driver-management') ? 'color: rgb(45, 185, 120);' : '' }}">Manage
                                Drivers</a></li>
                    @endif
                </ul>
            </div>
        </li>

        {{-- Requirements Management Sidebar --}}
        <li class="nav-item">
            @if (Gate::allows('permission', 'viewRequirement') || Gate::allows('permission', 'viewComRequirement'))
                <a class="nav-link" data-bs-toggle="collapse" href="#requirement-mgnt" aria-expanded='false'
                    aria-controls="requirement-mgnt">
                    <i class="menu-icon mdi mdi-format-list-bulleted"></i>
                    <span class="menu-title">Requirement Mgmt</span>
                    <i class="menu-arrow"></i>
                </a>
            @endif
            <div class="collapse" id="requirement-mgnt">
                <ul class="nav flex-column sub-menu" id="myTab">
                    {{-- <li class="nav-item"> <a class="nav-link" href="add-new-driver" style="{{Request::is('add-new-driver') ? 'color: rgb(45, 185, 120);':''}}">Add New Driver</a></li> --}}
                    @if (Gate::allows('permission', 'viewRequirement'))
                        <li class="nav-item"> <a class="nav-link" href="requirements-management"
                                style="{{ Request::is('requirements-management') ? 'color: rgb(45, 185, 120);' : '' }}">Manage
                                Requirements</a></li>
                    @endif
                    @if (Gate::allows('permission', 'viewComRequirement'))
                        <li class="nav-item"> <a class="nav-link" href="compliance-requirements-management"
                                style="{{ Request::is('compliance-requirements-management') ? 'color: rgb(45, 185, 120);' : '' }}">Manage
                                Compliance Req's</a></li>
                    @endif
                </ul>
            </div>
        </li>

        {{-- Vehicle Management Sidebar --}}
        @if (Gate::allows('permission', 'viewVehicleHeader') ||
                Gate::allows('permission', 'viewVehicleType') ||
                Gate::allows('permission', 'viewVehicle'))
            <li class="nav-item nav-category">Vehicle Management</li>
        @endif
        <li class="nav-item">
            @if (Gate::allows('permission', 'viewVehicleType') || Gate::allows('permission', 'viewVehicle'))
                <a class="nav-link" data-bs-toggle="collapse" href="#vehicle-type-mgnt" aria-expanded='false'
                    aria-controls="vehicle-type-mgnt">
                    <i class="menu-icon mdi mdi-bus"></i>
                    <span class="menu-title">Vehicle Mgmt</span>
                    <i class="menu-arrow"></i>
                </a>
            @endif
            <div class="collapse" id="vehicle-type-mgnt">
                <ul class="nav flex-column sub-menu" id="myTab">
                    @if (Gate::allows('permission', 'viewVehicleType'))
                        <li class="nav-item"> <a class="nav-link" href="vehicle-type-management"
                                style="{{ Request::is('vehicle-type-management') ? 'color: rgb(45, 185, 120);' : '' }}">Manage
                                Vehicle Type</a></li>
                    @endif
                    @if (Gate::allows('permission', 'viewVehicle'))
                        <li class="nav-item"> <a class="nav-link" href="vehicle-info-management"
                                style="{{ Request::is('vehicle-info-management') ? 'color: rgb(45, 185, 120);' : '' }}">Manage
                                Vehicle</a></li>
                    @endif
                </ul>
            </div>
        </li>


        @if (Gate::allows('permission', 'viewMap'))
            <li class="nav-item nav-category">SHUTTLE LOCATION MGMT</li>

            <li class="nav-item">
                @if (Gate::allows('permission', 'viewMap'))
                    <a class="nav-link" data-bs-toggle="collapse" href="#shuttle-map-mgnt" aria-expanded='false'
                        aria-controls="shuttle-map-mgnt">
                        <i class="menu-icon mdi mdi-google-maps"></i>
                        <span class="menu-title">Map Mgmt</span>
                        <i class="menu-arrow"></i>
                    </a>
                @endif
                <div class="collapse" id="shuttle-map-mgnt">
                    <ul class="nav flex-column sub-menu" id="myTab">
                        <li class="nav-item"> <a class="nav-link" href="travel-history-mngt"
                                style="{{ Request::is('travel-history-mngt') ? 'color: rgb(45, 185, 120);' : '' }}">Shuttle
                                location mapping</a></li>
                        <li class="nav-item"> <a class="nav-link" href="device-registration"
                                style="{{ Request::is('device-registration') ? 'color: rgb(45, 185, 120);' : '' }}">Device
                                registration</a></li>
                    </ul>
                </div>
            </li>
        @endif


        {{-- Company Management Sidebar --}}
        @if (Gate::allows('permission', 'viewCompanyHeader') ||
                Gate::allows('permission', 'viewCompany') ||
                Gate::allows('permission', 'viewDepartment') ||
                Gate::allows('permission', 'viewPosition'))
            <li class="nav-item nav-category">Company Management</li>
        @endif
        <li class="nav-item">
            @if (Gate::allows('permission', 'viewCompany') ||
                    Gate::allows('permission', 'viewDepartment') ||
                    Gate::allows('permission', 'viewPosition'))
                <a class="nav-link" data-bs-toggle="collapse" href="#company-mgnt" aria-expanded='false'
                    aria-controls="company-mgnt">
                    <i class="menu-icon mdi mdi-home-modern"></i>
                    <span class="menu-title">Company Mgmt</span>
                    <i class="menu-arrow"></i>
                </a>
            @endif
            <div class="collapse" id="company-mgnt">
                <ul class="nav flex-column sub-menu" id="myTab">
                    @if (Gate::allows('permission', 'viewCompany'))
                        <li class="nav-item"> <a class="nav-link" href="company-management"
                                style="{{ Request::is('company-management') ? 'color: rgb(45, 185, 120);' : '' }}">Manage
                                Company</a></li>
                    @endif
                    @if (Gate::allows('permission', 'viewDepartment'))
                        <li class="nav-item"> <a class="nav-link" href="department-management"
                                style="{{ Request::is('department-management') ? 'color: rgb(45, 185, 120);' : '' }}">Manage
                                Department</a></li>
                    @endif
                    @if (Gate::allows('permission', 'viewPosition'))
                        <li class="nav-item"> <a class="nav-link" href="position-management"
                                style="{{ Request::is('position-management') ? 'color: rgb(45, 185, 120);' : '' }}">Manage
                                Position</a></li>
                    @endif
                    
                </ul>
            </div>
        </li>

        {{-- Purchasing Management Sidebar --}}
        @if (Gate::allows('permission', 'viewPurchasingHeader'))
            <li class="nav-item nav-category">Purchasing Management</li>
        @endif
        <li class="nav-item">
            @if (Gate::allows('permission', 'viewPurchasingHeader'))
                <a class="nav-link" data-bs-toggle="collapse" href="#purchase-request-mgnt" aria-expanded='false'
                    aria-controls="purchase-request-mgnt">
                    <i class="menu-icon mdi mdi-home-modern"></i>
                    <span class="menu-title">Purchase Request</span>
                    <i class="menu-arrow"></i>
                </a>
            @endif
            <div class="collapse" id="purchase-request-mgnt">
                <ul class="nav flex-column sub-menu" id="myTab">
                    @if (Gate::allows('permission', 'viewPurchaseRequest'))
                        <li class="nav-item"> <a class="nav-link" href="purchase-request-management"
                                style="{{ Request::is('purchase-request-management') ? 'color: rgb(45, 185, 120);' : '' }}">PR / PO</a></li>
                    @endif

                    @if (Gate::allows('permission', 'viewConsolidateRequest'))
                    <li class="nav-item"> <a class="nav-link" href="consolidate-request-management"
                            style="{{ Request::is('consolidate-request-management') ? 'color: rgb(45, 185, 120);' : '' }}">Consolidate Purchase</a></li>
                    @endif

                    @if (Gate::allows('permission', 'viewApproveConsolidateRequest'))
                    <li class="nav-item"> <a class="nav-link" href="approve-consolidate-request-management"
                            style="{{ Request::is('approve-consolidate-request-management') ? 'color: rgb(45, 185, 120);' : '' }}">Approve Consolidate <br>Purchase</a></li>
                    @endif
                    
                </ul>
            </div>
        </li>



        @if (Gate::allows('permission', 'viewBillingHeader') || Gate::allows('permission', 'viewBilling'))
            <li class="nav-item nav-category">Billing Management</li>
        @endif
        <li class="nav-item">
            @if (Gate::allows('permission', 'viewBilling'))
                <a class="nav-link" data-bs-toggle="collapse" href="#billing-mgnt" aria-expanded='false'
                    aria-controls="billing-mgnt">
                    <i class="menu-icon mdi mdi-chart-bar"></i>
                    <span class="menu-title">Billing Mgmt</span>
                    <i class="menu-arrow"></i>
                </a>
            @endif
            <div class="collapse" id="billing-mgnt">
                {{-- <ul class="nav flex-column sub-menu" id="myTab">
                    @if (Gate::allows('permission', 'viewBilling'))
                        <li class="nav-item"> <a class="nav-link" href="billing-management"
                                style="{{ Request::is('billing-management') ? 'color: rgb(45, 185, 120);' : '' }}">Manage
                                Billing</a></li>
                    @endif
                </ul> --}}
                <ul class="nav flex-column sub-menu" id="myTab">
                    @if (Gate::allows('permission', 'viewBilling'))
                        <li class="nav-item"> <a class="nav-link" href="billing-summary"
                                style="{{ Request::is('billing-summary') ? 'color: rgb(45, 185, 120);' : '' }}">Billing
                                Summary</a></li>
                    @endif
                    @if (Gate::allows('permission', 'restoreBookingApproval'))
                    <li class="nav-item"> <a class="nav-link" href="booking-approval-management"
                            style="{{ Request::is('booking-approval-management') ? 'color: rgb(45, 185, 120);' : '' }}">
                            Billing Driver Summary</a></li>
                @endif
             
                </ul>

            </div>
        </li>

        @if (Gate::allows('permission', 'viewReportsHeader') || Gate::allows('permission', 'viewPassengersAttendanceReport'))
            <li class="nav-item nav-category">Reports Management</li>
        @endif
        <li class="nav-item">
            @if (Gate::allows('permission', 'viewPassengersAttendanceReport'))
                <a class="nav-link" data-bs-toggle="collapse" href="#reports-mgnt" aria-expanded='false'
                    aria-controls="reports-mgnt">
                    <i class="menu-icon mdi mdi-chart-bar"></i>
                    <span class="menu-title">Reports</span>
                    <i class="menu-arrow"></i>
                </a>
            @endif
            <div class="collapse" id="reports-mgnt">
                <ul class="nav flex-column sub-menu" id="myTab">
                    @if (Gate::allows('permission', 'viewPassengersAttendanceReport'))
                        <li class="nav-item"> <a class="nav-link" href="passenger-reports-management"
                                style="{{ Request::is('passenger-reports-management') ? 'color: rgb(45, 185, 120);' : '' }}">Manage
                                Passenger Reports</a></li>
                    @endif
                    @if (Gate::allows('permission', 'restoreBookingApproval'))
                        <li class="nav-item"> <a class="nav-link" href="manage-financial-summary-reports"
                                style="{{ Request::is('manage-financial-summary-reports') ? 'color: rgb(45, 185, 120);' : '' }}">
                                Manage Financial Summary</a></li>
                    @endif
                </ul>
            </div>
        </li>





    </ul>
</nav>
