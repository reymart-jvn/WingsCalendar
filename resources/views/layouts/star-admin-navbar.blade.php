<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row ">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
            <span class="icon-menu"></span>
          </button>
        </div>
        <div>
          <a class="navbar-brand brand-logo" href="index.html">
            <img style="height: 70px !important;" src="{{ asset('assets/images/logos/wings.png') }}" alt="logo" />
          </a>
          <a class="navbar-brand brand-logo-mini" href="index.html">
            <img style="height: 29px !important;" src="{{ asset('assets/images/logos/wings.png') }}" alt="logo" />
          </a>
        </div>
       </div>
       <div class="navbar-menu-wrapper d-flex align-items-top"> 
        <div id="good_morning">
        <ul class="navbar-nav" >
          <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
            <h2>今日は, <span class="text-black fw-bold mb-0">{{ Auth::user()->name }}</span></h2>
            <h7 class="header-title">{{ getCompanyName() }}</h7>
            <br>
          </li>
        </ul>
        </div>
        <ul class="navbar-nav ms-auto">
          <h2 class="header-title">{{ getCompanyCode() }}</h2>
          <li class="nav-item dropdown d-none d-lg-block user-dropdown">
           
            <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
             <img class="img-md rounded-circle" src="{{ asset("assets/images/face8.png") }}" alt="Profile image"> </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
              <div class="dropdown-header text-center">
                <img class="img-md rounded-circle" src="{{ asset("assets/images/face8.png") }}" alt="Profile image">
                <p class="mb-1 mt-3 font-weight-semibold" id="user_fulname">{{ Auth::user()->name }}</p>
                <p class="fw-light text-muted mb-0" id="user_email">{{ Auth::user()->email }}</p>
              </div>
              {{-- <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My Profile <span class="badge badge-pill badge-danger">1</span></a>
              <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-message-text-outline text-primary me-2"></i> Messages</a>
              <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-calendar-check-outline text-primary me-2"></i> Activity</a>
              <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-help-circle-outline text-primary me-2"></i> FAQ</a> --}}
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                  <a class="dropdown-item" href="{{ route('login') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                  <i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i> {{ __('サインアウト') }}</a>
                
              </form>
              <a class="dropdown-item"  onclick="window.location='/password-change'">
                <i class="dropdown-item-icon mdi mdi-lock text-primary me-2"></i> パスワード変更</a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
</div>

