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
                                <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                                <li class="breadcrumb-item"><a href="#">التناية</a></li>
                                <li class="breadcrumb-item active">تناية حليات</li>
                            </ol>
                        </div>
                        <h4 class="page-title">تناية حليات</h4>
                    </div>
                    <!--end page-title-box-->
                </div>
                <!--end col-->
            </div>
            <!-- end page title end breadcrumb -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">مجرة المطر المجلفنة</h4>
                        </div>
                        <!--end card-header-->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 col-lg-3">
                                    <div class="mb-3 d-flex">
                                        <label for="example-number-input" class="col-form-label">سمك
                                            اللوح :</label>
                                        <div class="d-flex align-items-center w-100">
                                            <input class="form-control" type="number" placeholder="مثال : 120 مم"
                                                id="example-number-input">
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="mb-3 d-flex">
                                        <label for="example-number-input" class="col-form-label">طول
                                            اللوح :</label>
                                        <div class="d-flex align-items-center w-100">
                                            <input class="form-control" type="number" placeholder="مثال : 120 مم"
                                                id="example-number-input">
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="mb-3 d-flex">
                                        <label for="example-number-input" class="col-form-label">عرض اللوح
                                            :</label>
                                        <div class="d-flex align-items-center w-100">
                                            <input class="form-control" type="number" placeholder="مثال : 120 مم"
                                                id="example-number-input">
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="mb-3 d-flex">
                                        <label for="example-number-input" class="col-form-label">الوزن
                                            :</label>
                                        <div class="d-flex align-items-center w-100">
                                            <input class="form-control" id="example-number-input" disabled="">
                                            <p class="mb-0 fw-semibold d-none">120 كجم</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 d-flex">
                                    <div class="btn-group ms-auto">
                                        <button type="submit" class="btn btn-primary" onclick="showCol()"> <i
                                                class="mdi mdi-gesture-double-tap me-1"></i> تأكيد</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">الحليات الأخري</h4>
                        </div>
                        <!--end card-header-->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 col-lg-3">
                                    <div class="mb-3 d-flex">
                                        <label for="example-number-input" class="col-form-label">عدد النزلات
                                            :</label>
                                        <div class="d-flex align-items-center w-100">
                                            <input class="form-control" type="number" placeholder="مثال : 10 نزلات"
                                                id="example-number-input">
                                            <p class="mb-0 fw-semibold d-none">10 نزلات</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="mb-3 d-flex">
                                        <label for="example-number-input" class="col-form-label">طول
                                            اللوح :</label>
                                        <div class="d-flex align-items-center w-100">
                                            <input class="form-control" type="number" placeholder="مثال : 120 مم"
                                                id="example-number-input">
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="mb-3 d-flex">
                                        <label for="example-number-input" class="col-form-label">العدد الكلي
                                            :</label>
                                        <div class="d-flex align-items-center w-100">
                                            <input class="form-control" type="number" placeholder="مثال : 120 "
                                                id="example-number-input">
                                            <p class="mb-0 fw-semibold d-none">120</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12 d-flex">
                                    <div class="btn-group ms-auto">
                                        <button type="submit" class="btn btn-primary" onclick="showCol()"> <i
                                                class="mdi mdi-gesture-double-tap me-1"></i> تأكيد</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
                <div class="col-lg-12 d-none" id="orderDetailsCol">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">تفاصيل الطلب</h4>

                        </div>
                        <!--end card-header-->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-3 row">
                                        <table>
                                            <tbody class="table table-primary">
                                                <!-- <tr>
                                                    <td><label for="example-number-input"
                                                            class="col-12 col-form-label d-flex">المجموع الكلي
                                                            :</label></td>
                                                    <td>
                                                        <p class="mb-0">1978 جنيه</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><label for="example-number-input"
                                                            class="col-12 col-form-label d-flex">الضريبة
                                                            :</label></td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <p class="mb-0">322 جنيه</p>
                                                            <span
                                                                class="badge bg-info text-dark ms-4 px-3 d-flex align-items-center fw-bold">14%</span>
                                                        </div>
                                                    </td>
                                                </tr> -->
                                                <tr>
                                                    <td><label for="example-number-input"
                                                            class="col-12 col-form-label d-flex">المبلغ
                                                            المستحق:</label>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0">2300 جنيه</p>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12 d-flex">
                                    <div class="btn-group ms-auto">
                                        <a type="submit" class="btn btn-primary" href="#" data-bs-toggle="modal"
                                            data-bs-target="#paymentModal"> <i class="mdi mdi-credit-card me-1"></i>
                                            دفع</a>
                                        <a href="#" class="btn btn-secondary ms-1"> <i
                                                class="mdi mdi-cart-plus me-1"></i> اضافة الي السلة</a>
                                    </div>
                                </div>
                            </div>
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
<!-- end page-wrapper -->

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">عملية البيع</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div class="mb-3 row">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td><label for="example-number-input"
                                            class="col-12 col-form-label d-flex">المبلغ المستحق
                                            :</label></td>
                                    <td>
                                        <!-- <p class="mb-0">2300 جنيه</p> -->
                                        <input class="form-control" type="text" placeholder="2300 جنيه" disabled>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="example-number-input"
                                            class="col-12 col-form-label d-flex">المبلغ المدفوع
                                            :</label></td>
                                    <td>
                                        <!-- <p class="mb-0">2400 جنيه</p> -->
                                        <input class="form-control bg-transparent" type="text"
                                            placeholder="2400 جنيه">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="example-number-input"
                                            class="col-12 col-form-label d-flex">الباقي:</label>
                                    </td>
                                    <td>
                                        <!-- <p class="mb-0">100 جنيه</p> -->
                                        <input class="form-control" type="text" placeholder="100 جنيه" disabled>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="executeExample('successPayment')">
                    <i class="mdi mdi-gesture-double-tap me-1"></i> تأكيد</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> <i
                        class="mdi mdi-cancel me-1"></i> إلغاء</button>

                <div class="btn-group ms-auto">
                    <a type="submit" class="btn btn-info" href="apps-invoice.html"> <i
                            class="mdi mdi-printer me-1"></i> طباعة
                        الإيصال</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
