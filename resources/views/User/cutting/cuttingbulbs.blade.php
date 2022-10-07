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
                                <li class="breadcrumb-item"><a href="#">التقطيع</a></li>
                                <li class="breadcrumb-item active">تقطيع لمبة</li>
                            </ol>
                        </div>
                        <h4 class="page-title">تقطيع لمبة</h4>
                    </div>
                    <!--end page-title-box-->
                </div>
                <!--end col-->
            </div>
            <!-- end page title end breadcrumb -->
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{route('user.cuttingbulbs.order')}}" method="post">
                        @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">اضافة فاتورة</h4>
                        </div>
                        <!--end card-header-->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 d-flex">
                                        <label for="example-number-input" class="col-form-label">سمك
                                            اللوح :</label>
                                        <div class="d-flex align-items-center w-100">
                                            <input class="form-control" type="number" name="thickness" placeholder="مثال : 120 مم"
                                                id="example-number-input">
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 d-flex">
                                        <label for="example-number-input" class="col-form-label">طول
                                            اللوح :</label>
                                        <div class="d-flex align-items-center w-100">
                                            <input class="form-control" type="number" name="length" placeholder="مثال : 1234"
                                                id="example-number-input">
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 d-flex">
                                        <label for="example-number-input" class="col-form-label">عرض اللوح
                                            :</label>
                                        <div class="d-flex align-items-center w-100">
                                            <input class="form-control" type="number" name="weidth" placeholder="مثال : 1234"
                                                id="example-number-input">
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 d-flex">
                                        <label for="example-number-input" class="col-form-label">الوزن
                                            :</label>
                                        <div class="d-flex align-items-center w-100">
                                            <input class="form-control" name="weight" id="example-number-input" disabled="">
                                            <p class="mb-0 fw-semibold d-none">120 كجم</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 d-flex">
                                        <label for="example-number-input" class="col-form-label">طول القطع بالمتر
                                            :</label>
                                        <div class="d-flex align-items-center w-100">
                                            <input class="form-control" type="number" name="cuttinglength" placeholder="مثال : 4 متر"
                                                id="example-number-input">
                                            <p class="mb-0 fw-semibold d-none">4 متر</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="mb-3 d-flex">
                                        <label for="example-number-input" class="col-form-label text-end">عدد
                                            الألواح :</label>
                                        <div class="d-flex align-items-center">
                                            <input class="form-control" type="number" name="quantity" placeholder="مثال : 12 لوح"
                                                id="example-number-input">
                                            <p class="mb-0 fw-semibold d-none">12 لوح</p>
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
                    </form>
                    <!--end card-->
                </div>
                <!--end col-->
                @if ($order)
                @foreach ($order->orderdetailes as $detailes)
                <div class="col-lg-12 " id="orderDetailsCol">
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
                                       <a type="submit" class="btn btn-primary" href="{{route('user.deleteOrderDetailes',$detailes->operationdetailes->id)}}"
                                          >الغاء</a>
                                       {{-- <a href="#" class="btn btn-secondary ms-1"> <i
                                               class="mdi mdi-cart-plus me-1"></i> اضافة الي السلة</a> --}}
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
@endsection
