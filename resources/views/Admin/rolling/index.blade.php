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
            @foreach ($rolleingnames as $rollingname)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">سعر مصنعية الدرفلة - {{$rollingname->name}}</h4>
                            <button class="btn p-0">
                                <i class="ti ti-pencil"></i>
                            </button>
                        </div>
                        <!--end card-header-->
                        <div class="card-body">
                            <form action="{{route('rollings.update',0)}}" method="post">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{$rollingname->id}}">
                                <div class="row mb-3 g-3">
                                    <div class="col-12">
                                        <label for="example-number-input" class="col-form-label">سعر مصنعية الكيلو بالجنيه:</label>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="input-group align-items-center">
                                            <label for="example-number-input" class="col-form-label me-2">السعر الأساسي:</label>
                                            <input class="form-control" name="price" type="text" placeholder="مثال : 10 جنيه"
                                                id="example-number-input" value="{{$rollingname->price}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="input-group align-items-center">
                                            <label for="example-number-input" class="col-form-label me-2">الوزن الحد الأدنى:</label>
                                            <input class="form-control" name="smallweight" type="text" placeholder="مثال : 25 كجم"
                                                id="example-number-input" value="{{$rollingname->smallweight}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="input-group align-items-center">
                                            <label for="example-number-input" class="col-form-label me-2">سعر الوزن الأقل:</label>
                                            <input class="form-control" name="lesspriceweight" type="text" placeholder="مثال : 15 جنيه"
                                                id="example-number-input" value="{{$rollingname->lesspriceweight}}">
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
                            </form>
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
            </div>
            @endforeach
        </div><!-- container -->
    </div>
    <!-- end page content -->
</div>
@endsection
@section('scripts')
<script src="{{asset('assets/js/alerts.js')}}"></script>
@endsection
