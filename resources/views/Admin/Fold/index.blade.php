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
                                <li class="breadcrumb-item"><a href="{{route('Admin.dashboard')}}">الرئيسية</a></li>
                                <li class="breadcrumb-item"><a href="#">قائمة الأسعار</a></li>
                                <li class="breadcrumb-item active">التناية</li>
                            </ol>
                        </div>
                        <h4 class="page-title">التناية</h4>
                    </div>
                    <!--end page-title-box-->
                </div>
                <!--end col-->
            </div>
            <!-- end page title end breadcrumb -->
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">سعر تناية الألواح</h4>
                                <button class="btn p-0">
                                    <i class="ti ti-pencil"></i>
                                </button>
                            </div>
                            <!--end card-header-->
                            <form action="{{route('folds.update',0)}}" method="post">
                                @csrf
                            @method('put')
                            <input type="hidden" name="type" value="1">
                            <div class="card-body">
                                <div class="row mb-3 g-3">
                                    <div class="col-12">
                                        <label for="example-number-input" class="col-form-label">سعر
                                            النزلة :</label>
                                    </div>
                                    @foreach ($foldpanelsprices as $foldpanelsprice)
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="row">
                                            <label for="example-number-input" class="col-sm-4 col-form-label text-end">{{$foldpanelsprice->name}}</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <input class="form-control" type="text" name='price[]' value='{{$foldpanelsprice->price}}' placeholder="مثال : 10 جنيه"
                                                    id="example-number-input">
                                                <p class="mb-0 fw-semibold d-none">10 جنيه</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex">
                                        <div class="btn-group ms-auto">
                                            <button type="submit" class="btn btn-primary">تأكيد</button>
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
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">سعر تناية الحليات</h4>
                                <button class="btn p-0">
                                    <i class="ti ti-pencil"></i>
                                </button>
                            </div>
                            <!--end card-header-->
                            <form action="{{route('folds.update',0)}}" method="post">
                            @csrf
                            @method('put')
                            <input type="hidden" name="type" value="2">
                            <div class="card-body">
                            <div class="row mb-3 g-3">
                                <div class="col-sm-6 col-lg-4">
                                    <div class="input-group align-items-center">
                                        <label for="example-number-input" class="col-form-label me-2">سعر مصنعية
                                             الكيلو
                                            :</label>
                                        <input class="form-control" type="text" name="tan" placeholder="مثال : 10000 جنيه"
                                            id="example-number-input" value="{{$foldheliatsprices->first()->price}}">
                                        <p class="mb-0 fw-semibold d-none">10000 جنيه</p>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="input-group align-items-center">
                                        <label for="example-number-input" class="col-form-label me-2">سعر المتر
                                             الطولى لكل نزلة
                                            :</label>
                                        <input class="form-control" type="text" name="meter" placeholder="مثال : 100 جنيه"
                                            id="example-number-input" value="{{$foldheliatothersprices->first()->price}}">
                                        <p class="mb-0 fw-semibold d-none"> جنيه</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 d-flex">
                                    <div class="btn-group ms-auto">
                                        <button type="submit" class="btn btn-primary">تأكيد</button>
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
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">سعر تناية البلتات</h4>
                                <button class="btn p-0">
                                    <i class="ti ti-pencil"></i>
                                </button>
                            </div>
                            <!--end card-header-->
                            <div class="card-body">
                                <form action="{{route('folds.update',0)}}" method="post">
                            @csrf
                            @method('put')
                            <input type="hidden" name="type" value="3">
                                <div class="row mb-3 g-3">
                                    @foreach ($foldpeltsprices as $foldpeltsprice)
                                    <div class="col-12 col-md-6">
                                        <div class="border rounded-3 p-3">
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <h5 class="fw-bold">سمك {{$foldpeltsprice->name}}</h5>
                                                </div>
                                                @foreach ($foldpeltsprice->foldLength as $foldlength)
                                                <div class="col-12 col-md-6 mb-2">
                                                    <div class="row">
                                                        <label for="example-number-input"
                                                            class="col-sm-4 col-form-label text-end">≥
                                                            {{$foldlength->length}} متر
                                                            :</label>
                                                        <div class="col-sm-8 d-flex align-items-center">
                                                            <input class="form-control" name='price_length[]' type="text" value='{{$foldlength->price}}'
                                                                placeholder="مثال : 10 جنيه" id="example-number-input">
                                                            <p class="mb-0 fw-semibold d-none">10 جنيه</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex">
                                        <div class="btn-group ms-auto">
                                            <button type="submit" class="btn btn-primary">تأكيد</button>
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
<script src="{{asset('assets/js/alerts.js')}}"></script>
@endsection
