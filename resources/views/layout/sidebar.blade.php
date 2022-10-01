<div class="left-sidebar">
    <!-- LOGO -->
    <div class="brand">
        <a href="index.html" class="logo">
            <span>
                <img src="../assets/images/logos/logo.png" alt="logo-small" class="logo-sm">
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
                        <a class="nav-link" href="{{route('Admin.dashboard')}}"><i
                                class="ti ti-home-2 menu-icon"></i><span>الرئيسية</span></a>
                    </li>
                    <!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="#processSetup" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="processSetup"><i
                                class="ti ti-file-invoice menu-icon"></i><span>المبيعات</span></a>
                        <div class="collapse " id="processSetup">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="invoices-manage.html">إدارة الفواتير</a>
                                </li>
                                <!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="invoices-refund.html">الفواتير المرتجعة</a>
                                </li>
                                <!--end nav-item-->
                            </ul>
                            <!--end nav-->
                        </div>
                    </li>
                    <!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="#priceSetup" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="priceSetup"><i
                                class="ti ti-currency-dollar menu-icon"></i><span>قائمة الأسعار</span></a>
                        <div class="collapse " id="priceSetup">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('weldingwires.index')}}">اللحام</a>
                                </li>
                                <!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('rollings.index')}}">الدرفلة</a>
                                </li>
                                <!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="#">التقطيع</a>
                                </li>
                                <!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="#">التناية</a>
                                </li>
                                <!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="#">التخريم</a>
                                </li>
                                <!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="#">المخرطة</a>
                                </li>
                                <!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="#">البناطة</a>
                                </li>
                                <!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="#">الدهان</a>
                                </li>
                                <!--end nav-item-->
                            </ul>
                            <!--end nav-->
                        </div>
                    </li>
                    <!--end nav-item-->
                </ul>
            </div>
            <!--end sidebarCollapse-->
        </div>
    </div>
</div>
