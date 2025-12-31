@extends('user_temp')
@section('content')

<div class="page-wrapper">

    <!-- Page Content-->
    <div class="page-content-tab">

        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="float-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active">الرئيسية</li>
                            </ol>
                        </div>
                        <h4 class="page-title">مرحبًا بك {{ auth()->user()->name ?? '' }}</h4>
                    </div>
                    <!--end page-title-box-->
                </div>
                <!--end col-->
            </div>
            <!-- end page title end breadcrumb -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-muted mb-4">يرجى اختيار خدمة للمتابعة.</p>

                            <div class="row g-3">
                                <div class="col-12 col-sm-6 col-lg-4">
                                    <a href="{{ route('user.materials.normal') }}" class="text-decoration-none">
                                        <div class="card shadow-sm h-100" style="border-color:#e5e7eb;">
                                            <div class="card-body d-flex align-items-start">
                                                <div class="me-3" style="font-size:28px;"><i class="ti ti-box menu-icon"></i></div>
                                                <div>
                                                    <h5 class="card-title mb-1">خامات عادية</h5>
                                                    <p class="card-text text-muted mb-0">طلب الخامات العادية.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-12 col-sm-6 col-lg-4">
                                    <a href="{{ route('user.materials.standard') }}" class="text-decoration-none">
                                        <div class="card shadow-sm h-100" style="border-color:#e5e7eb;">
                                            <div class="card-body d-flex align-items-start">
                                                <div class="me-3" style="font-size:28px;"><i class="ti ti-box menu-icon"></i></div>
                                                <div>
                                                    <h5 class="card-title mb-1">خامات استاندرد</h5>
                                                    <p class="card-text text-muted mb-0">طلب الخامات الاستاندرد.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

<div class="col-12 col-sm-6 col-lg-4">
    <a href="{{ route('user.welding') }}" class="text-decoration-none">
        <div class="card shadow-sm h-100" style="border-color:#e5e7eb;">
            <div class="card-body d-flex align-items-start">
                <div class="me-3" style="font-size:28px;"><i class="ti ti-flare menu-icon"></i></div>
                <div>
                    <h5 class="card-title mb-1">اللحام</h5>
                    <p class="card-text text-muted mb-0">تقديم طلبات اللحام.</p>
                </div>
            </div>
        </div>
    </a>
</div>

                                <div class="col-12 col-sm-6 col-lg-4">
                                    <a href="{{ route('user.rolling') }}" class="text-decoration-none">
                                        <div class="card shadow-sm h-100" style="border-color:#e5e7eb;">
                                            <div class="card-body d-flex align-items-start">
                                                <div class="me-3" style="font-size:28px;"><i class="ti ti-circle menu-icon"></i></div>
                                                <div>
                                                    <h5 class="card-title mb-1">الدرفلة</h5>
                                                    <p class="card-text text-muted mb-0">إنشاء أوامر الدرفلة.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-12 col-sm-6 col-lg-4">
                                    <a href="{{ route('user.cutting.boards') }}" class="text-decoration-none">
                                        <div class="card shadow-sm h-100" style="border-color:#e5e7eb;">
                                            <div class="card-body d-flex align-items-start">
                                                <div class="me-3" style="font-size:28px;"><i class="ti ti-box-multiple menu-icon"></i></div>
                                                <div>
                                                    <h5 class="card-title mb-1">التقطيع</h5>
                                                    <p class="card-text text-muted mb-0">تقطيع ألواح، لمبات وبلتات.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-12 col-sm-6 col-lg-4">
                                    <a href="{{ route('user.folding.boards') }}" class="text-decoration-none">
                                        <div class="card shadow-sm h-100" style="border-color:#e5e7eb;">
                                            <div class="card-body d-flex align-items-start">
                                                <div class="me-3" style="font-size:28px;"><i class="ti ti-currency-leu menu-icon"></i></div>
                                                <div>
                                                    <h5 class="card-title mb-1">التناية</h5>
                                                    <p class="card-text text-muted mb-0">ألواح، حليات وبلتات.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-12 col-sm-6 col-lg-4">
                                    <a href="{{ route('user.perforation') }}" class="text-decoration-none">
                                        <div class="card shadow-sm h-100" style="border-color:#e5e7eb;">
                                            <div class="card-body d-flex align-items-start">
                                                <div class="me-3" style="font-size:28px;"><i class="ti ti-chart-circles menu-icon"></i></div>
                                                <div>
                                                    <h5 class="card-title mb-1">التخريم</h5>
                                                    <p class="card-text text-muted mb-0">إنشاء أوامر التخريم.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- container -->

        <!-- Footer Start -->
        <footer class="footer text-center text-sm-start">
            &copy;
            <script>
                document.write(new Date().getFullYear())
            </script> JCloud Co
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end page content -->
</div>
<!-- end page-wrapper -->

@endsection
