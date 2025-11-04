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
                                <li class="breadcrumb-item"><a href="#">التقطيع</a></li>
                                <li class="breadcrumb-item active">تقطيع ألواح</li>
                            </ol>
                        </div>
                        <h4 class="page-title">تقطيع ألواح</h4>
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
                            {{-- <h4 class="card-title"> <a href="#" class="add-row" onclick="deleteRowFunction()"><i
                                        class="mdi mdi-plus-circle-outline text-warning"></i></a> اضافة عملية
                                أخري</h4> --}}
                        </div>
                        <!--end card-header-->
                        <form action="{{route('user.cuttingboard.order')}}" method="post">
                            @csrf
                        <div class="card-body cutting-body">
                            <div class="row">
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 row">
                                        <label for="example-number-input"
                                            class="col-sm-4 col-form-label text-end">سمك
                                            اللوح بالمم:</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <input class="form-control" type="number" name="thickness" id="thickness" min="4" max="12" step="0.1" value="{{ old('thickness') }}" placeholder="من 4مم الي 12 مم" oninput="if (this.value && parseFloat(this.value) < 4) { this.value = 4; } if (this.value && parseFloat(this.value) > 12) { this.value = 12; }">
                                            @error('thickness')
                                            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 row">
                                        <label for="example-number-input"
                                            class="col-sm-4 col-form-label text-end">طول
                                            اللوح بالسنتي:</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <input class="form-control" name="length" id="length" type="text" placeholder="مثال : 1234"
                                                id="example-number-input">
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 row">
                                        <label for="example-number-input"
                                            class="col-sm-4 col-form-label text-end">  عرض اللوح بالسنتي
                                            :</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <input class="form-control" type="text" name="width" placeholder="مثال : 1234"
                                                id="width">
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 row">
                                        <label for="example-number-input" class="col-sm-4 col-form-label text-end">عدد
                                            النزلات لكل لوح :</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <input class="form-control" name="cuttingqnty" id="cuttingqnty" type="number" placeholder="مثال : 5 نزلات"
                                                id="example-number-input">
                                            <p class="mb-0 fw-semibold d-none">5 نزلات</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 row">
                                        <label for="example-number-input"  class="col-sm-4 col-form-label text-end">عدد
                                            الألواح :</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <input class="form-control" type="number" id="quantity" name="quantity" placeholder="مثال : 12 لوح"
                                                id="example-number-input">
                                            <p class="mb-0 fw-semibold d-none">12 لوح</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row existed-row">
                               {{-- <div class="col-sm-2 col-lg-1">
                                     <a href="#" class="delete-row">
                                        <i class="mdi mdi-delete text-danger"></i>
                                    </a>
                                </div> --}}
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 row">
                                        <label for="example-number-input"
                                            class="col-sm-4 col-form-label text-end">الوزن
                                            :</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <input class="form-control" id="weight" disabled="">
                                            <p class="mb-0 fw-semibold d-none">120 كجم</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row new-row d-none">
                                <div class="col-sm-2 col-lg-1">
                                    {{-- <a href="#" class="delete-row">
                                        <i class="mdi mdi-delete text-danger"></i>
                                    </a> --}}
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 row">
                                        <label for="example-number-input" class="col-form-label text-end">عدد
                                            النزلات لكل لوح :</label>
                                        <div class="d-flex align-items-center">
                                            <input class="form-control" type="number" placeholder="مثال : 5 نزلات"
                                                id="example-number-input">
                                            <p class="mb-0 fw-semibold d-none">5 نزلات</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="mb-3 row">
                                        <label for="example-number-input" class="col-form-label text-end">عدد
                                            الألواح :</label>
                                        <div class="d-flex align-items-center">
                                            <input class="form-control" type="number"  placeholder="مثال : 12 لوح"
                                                id="example-number-input">
                                            <p class="mb-0 fw-semibold d-none">12 لوح</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row btns-row">
                                <div class="col-12 d-flex">
                                    <div class="btn-group ms-auto">
                                        <button type="submit" class="btn btn-primary" id="confirmBtn" disabled onclick="showCol()"> <i
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
                <!--end col-->
                @if ($order)

                 @foreach ($order->orderdetailes as $detailes)
                 <div class="col-lg-12 " id="orderDetailsCol">
                    <div class="card">
                        <div class="card-header">
                            <!--<h4>{{$detailes->opreationname}}</h4>-->
                            <h4 class="card-title">تفاصيل الطلب</h4>
                        </div>
                        <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 col-lg-4">
                                <div class="mb-3 row">
                                    <label for="example-number-input"
                                        class="col-sm-4 col-form-label text-end">سمك
                                        اللوح مم:</label>
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
                                        class="col-sm-4 col-form-label text-end">عرض اللوح بالسنتي:</label>
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
                                        class="col-sm-4 col-form-label text-end">طول
                                        اللوح بالسنتي:</label>
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
                                        عدد الألواح:</label>
                                    <div class="col-sm-8 d-flex align-items-center">
                                        <input class="form-control" name="length" type="text" placeholder="مثال : 1234" value="{{$detailes->operationdetailes->quantity}}" disabled
                                            id="example-number-input">
                                        <p class="mb-0 fw-semibold d-none">120 مم</p>
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
                                                            class="col-12 col-form-label d-flex">الوزن
                                                            :</label>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0">{{$detailes->operationdetailes->weight}} كيلو</p>
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
                            <!-- <div class="row">
                                <div class="col-12 d-flex">
                                    <div class="btn-group ms-auto">
                                        <a type="submit" class="btn btn-danger" href="{{route('user.deleteOrderDetailes',$detailes->id)}}"
                                           ><i class="mdi mdi-cancel me-1"></i>الغاء</a>
                                        {{-- <a href="#" class="btn btn-secondary ms-1"> <i
                                                class="mdi mdi-cart-plus me-1"></i> اضافة الي السلة</a> --}}
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <!--end card-body-->
                    </div>
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
