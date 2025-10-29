@extends('admin_temp')
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
                        <h4 class="page-title">الرئيسية</h4>
                    </div>
                    <!--end page-title-box-->
                </div>
                <!--end col-->
            </div>
            <!-- end page title end breadcrumb -->
            <div class="row">

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col align-self-center">
                                    <div class="media">
                                    <i class="las la-money-bill font-36 text-muted align-self-center"></i>
                                        <div class="media-body align-self-center ms-3">
                                            <h6 class="m-0 font-24 fw-bold">جنيه {{ number_format($totalRevenue ?? 0, 0) }}</h6>
                                            <p class="text-muted mb-0">إجمالي الإيرادات</p>
                                        </div>
                                        <!--end media body-->
                                    </div>
                                    <!--end media-->
                                </div>
                                <!--end col-->
                                <!-- <div class="col-auto align-self-center">
                                    <div class="">
                                        <div id="Revenu_Status_bar" class="apex-charts mb-n4"></div>
                                    </div>
                                </div> -->
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col align-self-center">
                                    <div class="media">
                                        <i class="las la-shopping-cart font-36 text-muted align-self-center"></i>
                                        <div class="media-body align-self-center ms-3">
                                            <h6 class="m-0 font-24 fw-bold">{{ $totalOrdersCount ?? 0 }}</h6>
                                            <p class="text-muted mb-0">إجمالي الأوردرات</p>
                                        </div>
                                        <!--end media body-->
                                    </div>
                                    <!--end media-->
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col text-center">
                                            <span class="h5  fw-bold">جنيه {{ number_format($todayRevenue ?? 0, 0) }}</span>
                                            <h6 class="text-uppercase text-muted mt-2 m-0 font-11">إيرادات اليوم
                                            </h6>
                                        </div>
                                        <!--end col-->
                                    </div> <!-- end row -->
                                </div>
                                <!--end card-body-->
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end col-->
                        <div class="col-12 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col text-center">
                                            <span class="h5  fw-bold">{{ $todayOrdersCount ?? 0 }}</span>
                                            <h6 class="text-uppercase text-muted mt-2 m-0 font-11">اوردرات اليوم
                                            </h6>
                                        </div>
                                        <!--end col-->
                                    </div> <!-- end row -->
                                </div>
                                <!--end card-body-->
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title">مشاهدة الفواتير</h4>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end card-header-->
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <i class="las la-file-invoice-dollar font-36 text-muted"></i>
                                </div>
                                <!--end col-->
                                <div class="col">
                                    <div class="input-group">
                                        <select class="form-select">
                                            <option selected>--- اختار ---</option>
                                            <option value="Jan 2022">يناير 2022</option>
                                            <option value="Feb 2022">فبراير 2022</option>
                                            <option value="Mar 2022">مارس 2022</option>
                                            <option value="Apr 2022">ابريل 2022</option>
                                        </select>
                                        <button class="btn btn-soft-primary btn-sm" type="button"><i
                                                class="las la-search"></i></button>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div><!-- end col-->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title">حالة الإيرادات</h4>
                                </div>
                                <!--end col-->
                                <div class="col-auto">
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-sm btn-outline-light dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            هذا الشهر<i class="las la-angle-down ms-1"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">اليوم</a>
                                            <a class="dropdown-item" href="#">الأسبوع الماضي</a>
                                            <a class="dropdown-item" href="#">الشهر الماضي</a>
                                            <a class="dropdown-item" href="#">هذه السنة</a>
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end card-header-->
                        <div class="card-body">
                            <div class="">
                                <div id="Revenu_Status" class="apex-charts"></div>
                            </div>
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div><!-- end col-->
            </div>
            <!--end row-->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title">تقارير الأرباح</h4>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end card-header-->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="border-top-0">تاريخ</th>
                                            <th class="border-top-0">عدد الأصناف</th>
                                            <th class="border-top-0">أرباح</th>
                                        </tr>
                                        <!--end tr-->
                                    </thead>
                                    <tbody>
                                        @forelse($dailyProfits ?? [] as $day)
                                        <tr>
                                            <td>{{ $day['date'] }}</td>
                                            <td>{{ $day['orders_count'] }}</td>
                                            <td>جنيه {{ number_format($day['revenue'], 0) }}</td>
                                        </tr>
                                        <!--end tr-->
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-center">لا توجد بيانات متاحة</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <!--end table-->
                            </div>
                            <!--end /div-->
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->

            </div>
            <!--end row-->

        </div><!-- container -->



        <!--Start Footer-->
        <!-- Footer Start -->
        <footer class="footer text-center text-sm-start">
            &copy;
            <script>
                document.write(new Date().getFullYear())
            </script> JCloud Co
        </footer>
        <!-- end Footer -->
        <!--end footer-->
    </div>
    <!-- end page content -->
</div>
@endsection
