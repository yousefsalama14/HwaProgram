@extends('user_temp')
@section('content')
<div class="page-wrapper">

    <!-- Page Content-->
    <div class="page-content-tab">

        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-check-circle me-2"></i>
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-alert-circle me-2"></i>
                    <strong>{{ session('error') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-alert-circle me-2"></i>
                    <strong>يرجى تصحيح الأخطاء التالية:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
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
                        <form action="{{route('user.foldingornaments.order')}}" method="post">
                            @csrf
                        <!--end card-header-->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 col-lg-3">
                                    <div class="mb-3 d-flex">
                                        <label for="example-number-input" class="col-form-label">سمك
                                            الصاج :</label>
                                        <div class="d-flex align-items-center w-100">
                                            <input class="form-control" type="text" name="thickness" id="thickness" placeholder="مثال : 120 مم"
                                                id="example-number-input">
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="mb-3 d-flex">
                                        <label for="example-number-input" class="col-form-label">طول
                                            مجري المطر بالسم:</label>
                                        <div class="d-flex align-items-center w-100">
                                            <input class="form-control" type="text" name="length" id="length" placeholder="مثال : 120 مم"
                                                id="example-number-input">
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="mb-3 d-flex">
                                        <label for="example-number-input" class="col-form-label">عرض مجري المطر بالسم
                                            :</label>
                                        <div class="d-flex align-items-center w-100">
                                            <input class="form-control" type="text" name="width" id="width" placeholder="مثال : 120 مم"
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
                                            <input class="form-control" type="number" id="quantity" name="quantity" placeholder="مثال : 120 "
                                                id="example-number-input">
                                            <p class="mb-0 fw-semibold d-none">120</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="mb-3 d-flex">
                                        <label for="example-number-input"
                                            class="col-form-label text-end fw-bold">الوزن
                                            :</label>
                                        <div class="d-flex align-items-center">
                                            <input class="form-control" id="weight" disabled="">
                                            <p class="mb-0 fw-semibold d-none">120 كجم</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 d-flex">
                                    <div class="btn-group ms-auto">
                                        <button type="submit" class="btn btn-primary" id="confirmBtn1" disabled onclick="showCol()"> <i
                                                class="mdi mdi-gesture-double-tap me-1"></i> تأكيد</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end card-body-->
                        </form>
                    </div>
                    <!--end card-->
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"> حليات الايكون</h4>
                        </div>

                        <!--end card-header-->
                        <form action="{{route('user.foldingotherornaments.order')}}" method="post">
                            @csrf
                        <div class="card-body">
                            <div class="row">
                            <div class="col-sm-6 col-lg-3">
                                    <div class="mb-3 d-flex">
                                        <label for="example-number-input" class="col-form-label">سمك
                                            الصاج :</label>
                                        <div class="d-flex align-items-center w-100">
                                            <input class="form-control" type="text" name="foldThickness" id="foldThickness" placeholder="مثال : 120 مم"
                                                id="example-number-input">
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="mb-3 d-flex">
                                        <label for="example-number-input" class="col-form-label">عرض الحليه بالسم
                                            :</label>
                                        <div class="d-flex align-items-center w-100">
                                            <input class="form-control" type="text" name="foldWidth" id="foldWidth" placeholder="مثال : 120 مم"
                                                id="example-number-input">
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="mb-3 d-flex">
                                        <label for="example-number-input" class="col-form-label">طول
                                            الحليه بالمتر:</label>
                                        <div class="d-flex align-items-center w-100">
                                            <input class="form-control" type="text" name="foldLength" placeholder="مثال : 120 مم"
                                                id="foldLength">
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="mb-3 d-flex">
                                        <label for="example-number-input" class="col-form-label">عدد النزلات
                                            :</label>
                                        <div class="d-flex align-items-center w-100">
                                            <input class="form-control" type="number" name='foldQnty'  placeholder="مثال : 10 نزلات"
                                                id="foldQnty">
                                            <p class="mb-0 fw-semibold d-none">10 نزلات</p>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-6 col-lg-3">
                                    <div class="mb-3 d-flex">
                                        <label for="example-number-input"
                                            class="col-form-label text-end fw-bold">الوزن
                                            :</label>
                                        <div class="d-flex align-items-center">
                                            <input class="form-control" id="foldWeight" name="foldWeight" disabled="">
                                            <p class="mb-0 fw-semibold d-none">120 كجم</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 d-flex">
                                    <div class="btn-group ms-auto">
                                        <button type="submit" class="btn btn-primary" id="confirmBtn2" disabled onclick="showCol()"> <i
                                                class="mdi mdi-gesture-double-tap me-1"></i> تأكيد</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                @if ($order)
                @foreach ($order->orderdetailes as $detailes)
                <div class="col-lg-12 " id="orderDetailsCol">
                   <div class="card">
                       <div class="card-header">
                           <h4>{{$detailes->opreationname}}</h4>
                           <h4 class="card-title">تفاصيل الطلب</h4>
                       </div>
                       <div class="row" >
                       <div class="col-sm-6 col-lg-4">
                                <div class="mb-3 row">
                                    <label for="example-number-input"
                                        class="col-sm-4 col-form-label text-end">سمك
                                        الصاج مم:</label>
                                    <div class="col-sm-8 d-flex align-items-center">
                                        <input class="form-control" name="thickness" type="text"
                                            placeholder="مثال : 1234" id="example-number-input" value="{{$detailes->operationdetailes->thickness}}" disabled>
                                        {{-- <p class="mb-0 fw-semibold">120 مم</p> --}}
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6 col-lg-4">
                                <div class="mb-3 row">
                                    <label for="example-number-input" style="font-size: 11px;"
                                        class="col-sm-4 col-form-label text-end">عرض مجري المطر  بالسنتي:</label>
                                    <div class="col-sm-8 d-flex align-items-center">
                                        <input class="form-control" name="width" id="width" type="text" placeholder="مثال : 1234"
                                            id="example-number-input" value="{{$detailes->operationdetailes->width}}">
                                        <p class="mb-0 fw-semibold d-none">120 مم</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-4">
                                <div class="mb-3 row">
                                    <label for="example-number-input" style="font-size: 11px;"
                                        class="col-sm-4 col-form-label text-end">طول مجري المطر
                                         بالسنتي:</label>
                                    <div class="col-sm-8 d-flex align-items-center">
                                        <input class="form-control" name="length" type="text" placeholder="مثال : 1234" value="{{$detailes->operationdetailes->length}}" disabled
                                            id="example-number-input">
                                        <p class="mb-0 fw-semibold d-none">120 مم</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="mb-3 row">
                                    <label for="example-number-input"
                                        class="col-sm-4 col-form-label text-end">
                                        العدد الكلي :</label>
                                    <div class="col-sm-8 d-flex align-items-center">
                                        <input class="form-control" name="length" type="text" placeholder="مثال : 1234" value="{{$detailes->operationdetailes->quantity}}" disabled
                                            id="example-number-input">
                                        <p class="mb-0 fw-semibold d-none">120 مم</p>
                                    </div>
                                </div>
                            </div>
                       </div>
                       </div>
                       <!--end card-header-->
                       <div class="card-body">
                           <div class="row">
                               <div class="col-sm-4">
                                   <div class="mb-3 row">
                                       <table>
                                           <tbody class="table table-primary">

                                               <tr>
                                                   <td><label for="example-number-input"
                                                           class="col-12 col-form-label d-flex">المبلغ
                                                           المستحق:</label>
                                                   </td>
                                                   <td>
                                                       <p class="mb-0">{{$detailes->price}} جنيه</p>
                                                   </td>
                                               </tr>

                                               <tr>
                                                <td><label for="example-number-input"
                                                        class="col-12 col-form-label d-flex">الوزن
                                                        :</label>
                                                </td>
                                                <td>
                                                    <p class="mb-0">{{$detailes->weight}} كيلو</p>
                                                </td>
                                            </tr>

                                           </tbody>
                                       </table>

                                   </div>
                               </div>

                           </div>
                           <!-- <div class="row">
                               <div class="col-12 d-flex">
                                   <div class="btn-group ms-auto">
                                       <a type="submit" class="btn btn-primary" href="{{route('user.deleteOrderDetailes',$detailes->id)}}"
                                          >الغاء</a>
                                       {{-- <a href="#" class="btn btn-secondary ms-1"> <i
                                               class="mdi mdi-cart-plus me-1"></i> اضافة الي السلة</a> --}}
                                   </div>
                               </div>
                           </div> -->
                       </div>
                       <!--end card-body-->
                   </div>
                   <!--end card-->
               </div>
                @endforeach
                @endif



                @if ($orderother)
                @foreach ($orderother->orderdetailes as $detailes)
                <div class="col-lg-12 " id="orderDetailsCol">
                   <div class="card">
                       <div class="card-header">
                           <h4>{{$detailes->opreationname}}</h4>
                           <h4 class="card-title">تفاصيل الطلب</h4>
                       </div>
                       <!--end card-header-->
                       <div class="row" >
                       <div class="col-sm-6 col-lg-4">
                                <div class="mb-3 row">
                                    <label for="example-number-input"
                                        class="col-sm-4 col-form-label text-end">سمك
                                        الصاج مم:</label>
                                    <div class="col-sm-8 d-flex align-items-center">
                                        <input class="form-control" name="thickness" type="text"
                                            placeholder="مثال : 1234" id="example-number-input" value="{{$detailes->operationdetailes->thickness}}" disabled>
                                        {{-- <p class="mb-0 fw-semibold">120 مم</p> --}}
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6 col-lg-4">
                                <div class="mb-3 row">
                                    <label for="example-number-input"
                                        class="col-sm-4 col-form-label text-end">عرض الحليه  بالسنتي:</label>
                                    <div class="col-sm-8 d-flex align-items-center">
                                        <input class="form-control" name="width" id="width" type="text" placeholder="مثال : 1234"
                                            id="example-number-input" value="{{$detailes->operationdetailes->width}}">
                                        <p class="mb-0 fw-semibold d-none">120 مم</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-4">
                                <div class="mb-3 row">
                                    <label for="example-number-input"
                                        class="col-sm-4 col-form-label text-end">طول الحليه
                                         بالسنتي:</label>
                                    <div class="col-sm-8 d-flex align-items-center">
                                        <input class="form-control" name="length" type="text" placeholder="مثال : 1234" value="{{$detailes->operationdetailes->length}}" disabled
                                            id="example-number-input">
                                        <p class="mb-0 fw-semibold d-none">120 مم</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="mb-3 row">
                                    <label for="example-number-input"
                                        class="col-sm-4 col-form-label text-end">
                                        عدد النزلات :</label>
                                    <div class="col-sm-8 d-flex align-items-center">
                                        <input class="form-control" name="length" type="text" placeholder="مثال : 1234" value="{{$detailes->operationdetailes->foldqnty}}" disabled
                                            id="example-number-input">
                                        <p class="mb-0 fw-semibold d-none">120 مم</p>
                                    </div>
                                </div>
                            </div>
                       </div>
                       </div>
                       <div class="card-body">
                           <div class="row">
                               <div class="col-sm-4">
                                   <div class="mb-3 row">
                                       <table>
                                           <tbody class="table table-primary">


                                               <tr>
                                                   <td><label for="example-number-input"
                                                           class="col-12 col-form-label d-flex">المبلغ
                                                           المستحق:</label>
                                                   </td>
                                                   <td>
                                                       <p class="mb-0">{{$detailes->price}} جنيه</p>
                                                   </td>
                                               </tr>
                                               <tr>
                                                <td><label for="example-number-input"
                                                        class="col-12 col-form-label d-flex">الوزن
                                                        :</label>
                                                </td>
                                                <td>
                                                    <p class="mb-0">{{$detailes->weight}} كيلو</p>
                                                </td>
                                            </tr>
                                           </tbody>
                                       </table>

                                   </div>
                               </div>

                           </div>
                           <!-- <div class="row">
                               <div class="col-12 d-flex">
                                   <div class="btn-group ms-auto">
                                       <a type="submit" class="btn btn-primary" href="{{route('user.deleteOrderDetailes',$detailes->id)}}"
                                          >الغاء</a>
                                       {{-- <a href="#" class="btn btn-secondary ms-1"> <i
                                               class="mdi mdi-cart-plus me-1"></i> اضافة الي السلة</a> --}}
                                   </div>
                               </div>
                           </div> -->
                       </div>
                       <!--end card-body-->
                   </div>
                   <!--end card-->
               </div>
                @endforeach
                @endif

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
@section('scripts')
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/weight.js')}}"></script>
<script src="{{asset('assets/js/alerts.js')}}"></script>
@endsection
