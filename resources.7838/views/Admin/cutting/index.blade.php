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
                                <li class="breadcrumb-item"><a href="#">قائمة الأسعار</a></li>
                                <li class="breadcrumb-item active">التقطيع</li>
                            </ol>
                        </div>
                        <h4 class="page-title">التقطيع</h4>
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
                            <h4 class="card-title">سعر تقطيع الألواح</h4>
                            <button class="btn p-0">
                                <i class="ti ti-pencil"></i>
                            </button>
                        </div>
                        <!--end card-header-->
                        <div class="card-body">
                            <form action="{{route('cuttings.update',0)}}" method="post">
                                <input type="hidden" name="type" value="1">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3 g-3">
                                <div class="col-12">
                                    <label for="example-number-input" class="col-form-label">سعر
                                         النزلة بالجنيه:</label>
                                </div>
                                @foreach ($cuttingpanelsprices as $cuttingprice)
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="input-group align-items-center">
                                            <label for="example-number-input" class="col-form-label me-2">{{ $cuttingprice->name}}
                                                :</label>
                                            <input class="form-control" name='price[]' type="number" placeholder="مثال : 10 جنيه"
                                                id="example-number-input" value="{{$cuttingprice->price}}">
                                            {{-- <p class="mb-0 fw-semibold d-none">{{}} جنيه</p> --}}
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
                            </form>
                        </div>
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
                            <h4 class="card-title">سعر تقطيع اللمبة بالجنيه</h4>
                            <button class="btn p-0">
                                <i class="ti ti-pencil"></i>
                            </button>
                        </div>
                        <!--end card-header-->
                        <div class="card-body">
                            <form action="{{route('cuttings.update',0)}}" method="post">
                                <input type="hidden" name="type" value="2">
                                @csrf
                                @method('PUT')
                            <div class="row mb-3 g-3">
                                <div class="col-sm-6 col-lg-4">
                                    @foreach ($cuttingpulpsprices as $cuttingpulpsprice)
                                        <div class="input-group align-items-center">
                                            <label for="example-number-input" class="col-form-label me-2">{{$cuttingpulpsprice->name}}
                                                :</label>
                                            <input class="form-control" type="number" name="price[]" value="{{$cuttingpulpsprice->price}}" placeholder="مثال : 10 جنيه"
                                                id="example-number-input">
                                            {{-- <p class="mb-0 fw-semibold d-none">10 جنيه</p> --}}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 d-flex">
                                    <div class="btn-group ms-auto">
                                        <button type="submit" class="btn btn-primary">تأكيد</button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
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
                            <h4 class="card-title">سعر تقطيع بلتات بالجنيه</h4>
                            <button class="btn p-0">
                                <i class="ti ti-pencil"></i>
                            </button>
                        </div>
                        <!--end card-header-->
                        <div class="card-body">
                            <form action="{{route('cuttings.update',0)}}" method="post">
                                <input type="hidden" name="type" value="3">
                                @csrf
                                @method('PUT')
                            <div class="row mb-3 g-3">
                                  @foreach ($cuttingpeltsprices as $cuttingpeltsprice)
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="input-group align-items-center">
                                            <label for="example-number-input" class="col-form-label me-2">{{$cuttingpeltsprice->name}}
                                                :</label>
                                            <input class="form-control" name='price[]' type="number" placeholder="مثال : 10 جنيه"
                                                id="example-number-input" value="{{$cuttingpeltsprice->price}}">
                                            {{-- <p class="mb-0 fw-semibold d-none">10 جنيه</p> --}}
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
