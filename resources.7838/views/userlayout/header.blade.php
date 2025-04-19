 <!-- Top Bar Start -->
    <!-- Top Bar Start -->
    <div class="topbar">
        <!-- Navbar -->
        <nav class="navbar-custom" id="navbar-custom">
            <ul class="list-unstyled topbar-nav float-end mb-0">
                <li class="dropdown">
                    <a class="nav-link dropdown-toggle nav-user" data-bs-toggle="dropdown" href="#" role="button"
                        aria-haspopup="false" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <img src="{{asset('assets/images/users/user.jpg')}}" alt="profile-user"
                                class="rounded-circle me-2 thumb-sm" />
                            <div>
                                <small class="d-none d-md-block font-11">الأدمن</small>
                                <span class="d-none d-md-block fw-semibold font-12">أحمد علي</span>
                                <!-- <i class="mdi mdi-chevron-down"></i></span> -->
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- <a class="dropdown-item" href="#"><i class="ti ti-user font-16 me-1 align-text-bottom"></i>
                            Profile</a>
                        <a class="dropdown-item" href="#"><i class="ti ti-settings font-16 me-1 align-text-bottom"></i>
                            Settings</a>
                        <div class="dropdown-divider mb-0"></div> -->
                        <a class="dropdown-item d-flex align-items-center" href="#"><i
                                class="ti ti-power font-16 me-1 align-text-bottom"></i>
                            تسجيل خروج</a>
                    </div>
                </li>
                <li>
                    <a href="{{route('user.cart')}}" class="nav-link nav-icon position-relative">
                        <i class="mdi mdi-medical-bag"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            @if (Session::get('orderqnty'))
                               {{Session::get('orderqnty')}}
                            @else
                                0
                            @endif
                            <span class="visually-hidden">uncompleted products</span>
                        </span>
                    </a>
                </li>
                <!--end topbar-profile-->

            </ul>
            <!--end topbar-nav-->

            <ul class="list-unstyled topbar-nav mb-0">
                <li>
                    <button class="nav-link button-menu-mobile nav-icon" id="togglemenu">
                        <i class="ti ti-menu-2"></i>
                    </button>
                </li>

            </ul>
        </nav>
        <!-- end navbar-->
    </div>
    <!-- Top Bar End -->
    <!-- Top Bar End -->
