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
                                <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                                <li class="breadcrumb-item active">التخريم</li>
                            </ol>
                        </div>
                        <h4 class="page-title">التخريم</h4>
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
                            <h4 class="card-title">اضافة فاتورة</h4>
                        </div>
                        <form action="{{route('perforation.order')}}" method="post">
                            @csrf
                        <!--end card-header-->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 row">
                                        <label for="thickness"
                                            class="col-sm-4 col-form-label text-end">سمك
                                            اللوح مم:</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <input class="form-control"  name="thickness" id="thickness" type="number"
                                                step="any"
                                                placeholder="مثال : 1234">
                                            {{-- <p class="mb-0 fw-semibold">120 مم</p> --}}
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 row">
                                        <label for="length"
                                            class="col-sm-4 col-form-label text-end">طول
                                            اللوح بالسنتي:</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <input class="form-control" name="length" id="length" type="number" placeholder="مثال : 1234">
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 row">
                                        <label for="width"
                                            class="col-sm-4 col-form-label text-end">عرض اللوح بالسنتي:</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <input class="form-control" name="width" id="width" type="number" placeholder="مثال : 1234">
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 row">
                                        <label for="perforationCount"
                                            class="col-sm-4 col-form-label text-end">
                                             عدد الاخرام:</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <input class="form-control" name="perforationCount" id="perforationCount" type="number" placeholder="مثال : 1234">
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 row">
                                        <label for="punchDiameter"
                                            class="col-sm-4 col-form-label text-end">
                                            قطر البنطة :</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <input class="form-control" name="punchDiameter" id="punchDiameter" type="number" placeholder="مثال : 1234">
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 row">
                                        <label for="quantity"
                                            class="col-sm-4 col-form-label text-end">العدد
                                            الكلي :</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <input class="form-control" name="quantity"  type="number" placeholder="مثال : 1234"
                                                id="quantity">
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 row">
                                        <label for="weight"
                                            class="col-sm-4 col-form-label text-end">الوزن :</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <input class="form-control" id="weight" disabled>
                                            <p class="mb-0 fw-semibold d-none">120 كجم</p>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 row">
                                        <label
                                            class="col-sm-4 col-form-label text-end">نوع سلكة اللحام :</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <select class="form-select">
                                                <option value="0">2.5 مم</option>
                                                <option value="1">3 مم</option>
                                                <option value="2">4 مم</option>
                                            </select>
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-12 d-flex">
                                    <div class="btn-group ms-auto">
                                        <button type="submit" class="btn btn-primary"
                                            onclick="showCol()">تأكيد</button>
                                        {{-- <button type="submit" class="btn btn-secondary ms-1">تعديل</button> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
                @if ($order)
                @foreach ( $order->orderdetailes as $detailes)
                <div class="col-lg-12 " id="orderDetailsCol">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">تفاصيل الطلب</h4>
                        </div>

                        <!--end card-header-->
                        <div class="card-body">
                            <div class="row">
                            <div class="col-sm-6 col-lg-4">
                                <div class="mb-3 row">
                                    <label
                                        class="col-sm-4 col-form-label text-end">سمك
                                        اللوح مم:</label>
                                    <div class="col-sm-8 d-flex align-items-center">
                                        <input class="form-control" name="thickness" type="text" value="{{$detailes->operationdetailes->thickness}}" disabled>
                                        {{-- <p class="mb-0 fw-semibold">120 مم</p> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-4">
                                <div class="mb-3 row">
                                    <label
                                        class="col-sm-4 col-form-label text-end">طول
                                        اللوح بالسنتي:</label>
                                    <div class="col-sm-8 d-flex align-items-center">
                                        <input class="form-control" name="length" type="text" value="{{$detailes->operationdetailes->total_length}}" disabled>
                                        <p class="mb-0 fw-semibold d-none">120 مم</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-4">
                                <div class="mb-3 row">
                                    <label
                                        class="col-sm-4 col-form-label text-end">عرض اللوح بالسنتي:</label>
                                    <div class="col-sm-8 d-flex align-items-center">
                                        <input class="form-control" name="width" id="width" type="text" value="{{$detailes->operationdetailes->width}}" disabled>
                                        <p class="mb-0 fw-semibold d-none">120 مم</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-4">
                        <div class="mb-3 row">
                            <label for="perforationCount" class="col-sm-4 col-form-label text-end">عدد الاخرام:</label>
                            <div class="col-sm-8 d-flex align-items-center">
                                <input class="form-control" name="perforationCount" type="text" value="{{$detailes->operationdetailes->perforationCount}}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-4">
                        <div class="mb-3 row">
                            <label for="punchDiameter" class="col-sm-4 col-form-label text-end">قطر البنطة:</label>
                            <div class="col-sm-8 d-flex align-items-center">
                                <input class="form-control" name="punchDiameter" type="text" value="{{$detailes->operationdetailes->punchDiameter}}" disabled>
                            </div>
                        </div>
                    </div>

                            <div class="col-sm-6 col-lg-4">
                                <div class="mb-3 row">
                                    <label
                                        class="col-sm-4 col-form-label text-end">العدد
                                        الكلي :</label>
                                    <div class="col-sm-8 d-flex align-items-center">
                                        <input class="form-control" name="quantity" type="number" value="{{$detailes->operationdetailes->quantity}}" disabled>
                                        <p class="mb-0 fw-semibold d-none">120 مم</p>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                                            class="col-12 col-form-label d-flex">الوزن
                                                            :</label>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0">{{$detailes->weight}} كيلو</p>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><label for="example-number-input"
                                                            class="col-12 col-form-label d-flex">المبلغ
                                                            المستحق:</label>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0">{{$detailes->price}} جنيه</p>
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
                                        <a type="submit" class="btn btn-primary" href="{{route('user.deleteOrderDetailes',$detailes->id)}}" data-bs-toggle="modal"
                                            data-bs-target="#paymentModal">الغاء</a>
                                        <a href="#" class="btn btn-secondary ms-1">اضافة الي السلة</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                @endforeach
                @endif

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
                <button type="button" class="btn btn-primary"
                    onclick="executeExample('successPayment')">تأكيد</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إلغاء</button>

                <div class="btn-group ms-auto">
                    <a type="submit" class="btn btn-info" href="apps-invoice.html">طباعة
                        الإيصال</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="{{asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets/pages/sweet-alert.init.js')}}"></script>


<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/weight.js')}}"></script>
@endsection

