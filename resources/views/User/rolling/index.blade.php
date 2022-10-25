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
                                <li class="breadcrumb-item active">الدرفلة</li>
                            </ol>
                        </div>
                        <h4 class="page-title">الدرفلة</h4>
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
                        <!--end card-header-->
                        <form action="{{route('rolling.order')}}" method="post">
                            @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 row">
                                        <label for="example-number-input"
                                            class="col-sm-4 col-form-label text-end">نوع العملية :</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <select name="rollingname" id="inputState" class="form-select">
                                                {{-- <option selected>اختار نوع العملية ...</option> --}}
                                                @foreach ($rolleingnames as $rolleingname)
                                                 <option value="{{$rolleingname->id}}">{{$rolleingname->name}}</option>
                                                @endforeach
                                            </select>
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 row">
                                        <label for="example-number-input"
                                            class="col-sm-4 col-form-label text-end">سمك
                                            اللوح بالسنتي:</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <input class="form-control " id="thickness" name="thickness" type="number"
                                                placeholder="مثال : 1234" id="example-number-input">
                                            <p class="mb-0 fw-semibold">120 مم</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 row">
                                        <label for="example-number-input"
                                            class="col-sm-4 col-form-label text-end">طول
                                            اللوح بالسنتي:</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <input class="form-control" name="length" id="length" type="number" placeholder="مثال : 1234"
                                                id="example-number-input">
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 row">
                                        <label for="example-number-input"
                                            class="col-sm-4 col-form-label text-end">عرض اللوح بالسنتي:</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <input class="form-control" name="width" id="width" type="number" placeholder="مثال : 1234"
                                                id="example-number-input">
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 row">
                                        <label for="example-number-input"
                                            class="col-sm-4 col-form-label text-end">الوزن :</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <input class="form-control" id="weight" disabled>
                                            <p class="mb-0 fw-semibold d-none">120 كجم</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 row">
                                        <label for="example-number-input"
                                            class="col-sm-4 col-form-label text-end">العدد
                                            الكلي :</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <input class="form-control" type="number" name="quantity" placeholder="مثال : 1234"
                                                id="example-number-input">
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 d-flex">
                                    <div class="btn-group ms-auto">
                                        <button type="submit" class="btn btn-primary"
                                            onclick="showCol()">تأكيد</button>
                                        <button type="submit" class="btn btn-secondary ms-1">تعديل</button>
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

                        <div class="row">
                            <div class="col-sm-6 col-lg-4">
                                <div class="mb-3 row">
                                    <label for="example-number-input"
                                        class="col-sm-4 col-form-label text-end">سمك
                                        اللوح :</label>
                                    <div class="col-sm-8 d-flex align-items-center">
                                        <input class="form-control" name="thickness" type="number"
                                            placeholder="مثال : 1234" id="example-number-input" value="{{$detailes->operationdetailes->thickness}}" disabled>
                                        {{-- <p class="mb-0 fw-semibold">120 مم</p> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-4">
                                <div class="mb-3 row">
                                    <label for="example-number-input"
                                        class="col-sm-4 col-form-label text-end">طول
                                         :</label>
                                    <div class="col-sm-8 d-flex align-items-center">
                                        <input class="form-control" name="length" type="number" placeholder="مثال : 1234" value="{{$detailes->operationdetailes->length}}" disabled
                                            id="example-number-input">
                                        <p class="mb-0 fw-semibold d-none">120 مم</p>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6 col-lg-4">
                                <div class="mb-3 row">
                                    <label for="example-number-input"
                                        class="col-sm-4 col-form-label text-end">الوزن :</label>
                                    <div class="col-sm-8 d-flex align-items-center">
                                        <input class="form-control" name="weight" id="weight" type="number"  placeholder="مثال : 1234" value="{{$detailes->operationdetailes->weight}}" disabled
                                            id="example-number-input">
                                        <p class="mb-0 fw-semibold d-none">120 مم</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="mb-3 row">
                                    <label for="example-number-input"
                                        class="col-sm-4 col-form-label text-end">العدد
                                        الكلي :</label>
                                    <div class="col-sm-8 d-flex align-items-center">
                                        <input class="form-control" name="quantity" type="number" placeholder="مثال : 1234"  value="{{$detailes->operationdetailes->quantity}}" disabled
                                            id="example-number-input">
                                        <p class="mb-0 fw-semibold d-none">120 مم</p>
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
                            <div class="row">
                                <div class="col-12 d-flex">
                                    <div class="btn-group ms-auto">
                                        <a type="submit" class="btn btn-primary" href="{{route('user.deleteOrderDetailes',$detailes->id)}}">الغاء</a>
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

@endsection
@section('scripts')
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/weight.js')}}"></script>
@endsection
