    <!-- leftbar-menu -->
    <div class="left-sidebar">
        <!-- LOGO -->
        <div class="brand">
            <a href="index.html" class="logo">
                <span>
                    <img src="{{asset('assets/images/logos/logo.png')}}" alt="logo-small" class="logo-sm">
                </span>
            </a>
        </div>



        <!--end logo-->
        <div class="menu-content h-100" data-simplebar>
            <div class="menu-body navbar-vertical">
                <div class="collapse navbar-collapse tab-content" id="sidebarCollapse">
                    <!-- Navigation -->
                    <ul class="navbar-nav tab-pane active" id="Main" role="tabpanel">
                        <li class="nav-item">
                            <a class="nav-link" href="index.html"><i
                                    class="ti ti-home-2 menu-icon"></i><span>الرئيسية</span></a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('user.welding')}}"><i class="ti ti-flare menu-icon"></i><span>اللحام</span></a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('user.rolling')}}"><i class="ti ti-circle menu-icon"></i><span>الدرفلة</span></a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="#cutting" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="processSetup"><i class="ti ti-box-multiple menu-icon"></i><span>التقطيع</span></a>
                            <div class="collapse " id="cutting">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('user.cutting.boards')}}">تقطيع ألواح</a>
                                    </li>
                                    <!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('user.cutting.bulbs')}}">تقطيع لمبة</a>
                                    </li>
                                    <!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('user.cutting.pallet')}}">تقطيع بلتات</a>
                                    </li>
                                    <!--end nav-item-->
                                </ul>
                                <!--end nav-->
                            </div>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="#fold" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="processSetup"><i class="ti ti-currency-leu menu-icon"></i><span>التناية</span></a>
                            <div class="collapse " id="fold">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('user.folding.boards')}}">تناية ألواح</a>
                                    </li>
                                    <!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('user.folding.ornaments')}}">تناية حليات</a>
                                    </li>
                                    <!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('user.folding.pallet')}}">تناية بلتات</a>
                                    </li>
                                    <!--end nav-item-->
                                </ul>
                                <!--end nav-->
                            </div>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('user.perforation')}}"><i class="ti ti-chart-circles menu-icon"></i><span>التخريم</span></a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i
                                    class="ti ti-chart-bubble menu-icon"></i><span>المخرطة</span></a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="ti ti-test-pipe menu-icon"></i><span>البناطة</span></a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="ti ti-paint menu-icon"></i><span>الدهان</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#materials" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="materials"><i class="ti ti-box menu-icon"></i><span>الخامات</span></a>
                            <div class="collapse " id="materials">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('user.materials.normal')}}">خامات عادية</a>
                                    </li>
                                    <!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('user.materials.standard')}}">خامات استاندرد</a>
                                    </li>
                                    <!--end nav-item-->
                                </ul>
                                <!--end nav-->
                            </div>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('logout')}}"><i class="ti ti-logout menu-icon"></i><span>تسجيل الخروج</span></a>
                        </li>
                    </ul>
                </div>
                <!--end sidebarCollapse-->
            </div>
        </div>
    </div>
    <!-- end left-sidenav-->
